import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  editItem,
  cancelEditItem,
  changePageField,
  initEditItem,
  loadCategories,
  loadElements,
  loadParameters,
  updateParameters
} from './../actions/';

// CONTENT FIELDS
import TextField from './../ContentFields/TextField';
import RichTextField from './../ContentFields/RichTextField';
import ImageField from './../ContentFields/ImageField';
import DateField from './../ContentFields/DateField';
import ImagesField from './../ContentFields/ImagesField';
import ContentsField from './../ContentFields/ContentsField';
import BooleanField from './../ContentFields/BooleanField';
import LinkField from './../ContentFields/LinkField';
import VideoField from './../ContentFields/VideoField';
import LocalizationField from './../ContentFields/LocalizationField';
import FileField from './../ContentFields/FileField';
import TranslatedFileField from './../ContentFields/TranslatedFileField';


// WIDGETS LIST
import CommonWidget from './../Widgets/CommonWidget';
import ListWidget from './../Widgets/ListWidget';
import TitleImageWidget from './../Widgets/TitleImageWidget';


import InputSettingsField from './../../Typology/Settings/InputSettingsField';
import RadioSettingsField from './../../Typology/Settings/RadioSettingsField';
import SelectorSettingsField from './../../Typology/Settings/SelectorSettingsField';
import InputTranslatedSettingsField from './../../Typology/Settings/InputTranslatedSettingsField';
import BooleanSettingsField from './../../Typology/Settings/BooleanSettingsField';

import HiddenFilter from './Settings/HiddenFilter';
import VisibilitySettingsField from './Settings/Visibility/VisibilitySettingsField';

import ModalEditListItem from './ModalEditListItem';

import axios from 'axios';

class ModalEditItem extends Component {

  constructor(props){
    super(props);

    this.widgets = {
        CommonWidget: CommonWidget,
        TitleImageWidget: TitleImageWidget
    };

    // //console.log(" ModalEditItem :: construct ",props);

    this.state = {
        field : null,
        displayListItemModal : false,
        listItemInfo : null,
        parameters : null,
        templates : null
    };

    this.onModalClose = this.onModalClose.bind(this);
    this.onFieldChange = this.onFieldChange.bind(this);

    this.props.initEditItem();
    this.isOpen = false;
  }

  processProps(props) {

    //console.log("ModalEditItem :: field processProps ",props);

    var field = JSON.parse(JSON.stringify(props.modalEdit.item.data.field));
    field.identifier = "temp_"+JSON.stringify(props.modalEdit.item.pathToIndex);
    field.value = props.modalEdit.item.data.field !== undefined &&
      props.modalEdit.item.data.field.value !== undefined ? props.modalEdit.item.data.field.value : null;

    //console.log("ModalEditItem :: field after process : ",field);

    return field;
  }

  componentDidMount() {
    if(this.props.modalEdit.displayModal){
        this.modalOpen();
    }

    this.props.loadCategories();
    this.props.loadElements();
    this.props.loadParameters();
  }

  componentWillReceiveProps(nextProps)
  {
    var field = null;

    if(nextProps.modalEdit.displayModal){
        if(!this.isOpen){
          this.isOpen = true;

          this.modalOpen();

          this.props.updateParameters(
            this.props.app.layout,
            this.props.modalEdit.originalElements,
            this.props.app.parameters,
            this.props.app.parametersList,
          );

        }

        field = this.processProps(nextProps);
        //update widget settings
        field = this.updateSettingsFromConfig(field);

        var paramerters = this.getInitParameters(field);
        var templates = this.getElementTemplates(field);

        this.setState({
          parameters : paramerters,
          templates : templates
        });


    } else {
      if(this.isOpen){
        this.isOpen = false;
        this.modalClose();
      }
    }

    //get parameters

    //console.log("componentWillReceiveProps :: ");
    this.setState({
      field : field
    });

  }

  /**
  *   Widget configuration can be changed because some settings or $rule
  *   added directly to PHP. It's necessary to update the json stored in BBDD
  *   to update the avialabe settings, and modifiy if necessary
  */
  updateSettingsFromConfig(field) {

    var config = null;

    if(field.type == "widget"){
        config = WIDGETS[field.label];
    }
    else {
        config = FIELDS[field.label];
    }

    if(config == null){
      return field;
    }

    if(config.rules !== undefined ) {
      for(var id in config.rules){
        var rule = config.rules[id];
        if(field.rules[rule] === undefined){
          field.rules[rule] = null;
        }
      }
    }

    if(config.settings !== undefined ) {
      for(var id in config.settings){
        var setting = config.settings[id];
        if(field.settings[setting] === undefined){
          field.settings[setting] = null;
        }
      }
    }

    //console.log("updateSettingsFromConfig :: ",widgetConfig,field);

    return field;
  }

  
  getParamsMerged(settingsName, field, params) {

      //if formElementsV2Preload take elements from formv2
      var newParams = this.getElementParameters({
        name : settingsName == "formElementsV2Preload" ? 
          "formElementsV2" : settingsName,
        value : field.settings[settingsName]
      });

      //merge params with new Params
      for(var key in newParams){
        if(!this.paramExist(params,newParams[key].id)){
          params.push(newParams[key]);
        }
      }

      return params;
  }

  paramExist(params,id){
    for(var key in params){
      if(params[key].id == id)
        return true;
    }
    return false;
  }

  getInitParameters(field) {

    if(field == null || field.settings === undefined){
      return null;
    }

    return this.getFieldParameters(field);;
  }

  /**
   * Iterate through all field settings and update parameters when needed
   * @param {*} field 
   */
  getFieldParameters(field) {
      var params = [];

      console.log("getFieldParameters :: (field)",field);

      if(field.settings['formElementsV2Preload'] !== undefined){
        params = this.getParamsMerged('formElementsV2Preload',field,params);
      }

      console.log("getFieldParameters :: formElementsV2Preload (params)",JSON.parse(JSON.stringify(params)));

      if(field.settings['fileElements'] !== undefined){
        params = this.getParamsMerged('fileElements',field,params);
      }
      else if(field.settings['tableElements'] !== undefined){
        params = this.getParamsMerged('tableElements',field,params);
      }
      else if(field.settings['formElements'] !== undefined){
        params = this.getParamsMerged('formElements',field,params);
      }
      else if(field.settings['formElementsV2'] !== undefined){
        params = this.getParamsMerged('formElementsV2',field,params);
      }
      else {
        return null;
      }

      console.log("getFieldParameters :: result (params)",JSON.parse(JSON.stringify(params)));

      //console.log("getInitParameters :: params => ",params);
      return params;
  }

  onModalClose(e){
      e.preventDefault();
      this.props.cancelEditItem();
  }

  modalOpen() {
    TweenMax.to($("#modal-edit-item"),0.5,{opacity:1,display:"block",ease:Power2.easeInOut});
  }

  modalClose() {
    var self =this;
      TweenMax.to($("#modal-edit-item"),0.5,{display:"none",opacity:0,ease:Power2.easeInOut,onComplete:function(){
      }});
  }

  onFieldChange(field) {

    ////console.log("ModalEditItem :: onFieldChange => ",field);

    var stateField = this.state.field;
    stateField.value = field.value;
    this.setState({
        field : stateField
    });

    this.props.changePageField(
      stateField,
      this.props.modalEdit.item.pathToIndex,
      this.props.app.layout
    )

  }

  onWidgetChange(field) {

    var stateField = this.state.field;
    stateField.fields = field.fields;
    this.setState({
        field : stateField
    });

    this.props.changePageField(
      stateField,
      this.props.modalEdit.item.pathToIndex,
      this.props.app.layout
    )

  }

  onSubmit(e) {
    e.preventDefault();
    this.props.cancelEditItem();
  }

  renderField() {

    ////console.log("ModalEditItem : renderField => ",this.state.field);

    switch(this.state.field.type) {
      case FIELDS.TEXT.type:
        return (
          <TextField
            field={this.state.field}
            hideTab={true}
            onFieldChange={this.onFieldChange}
          />
        );
      case FIELDS.RICHTEXT.type:
        return (
          <RichTextField
            field={this.state.field}
            hideTab={true}
            onFieldChange={this.onFieldChange}
          />
        );
        case FIELDS.IMAGE.type:
          return (
            <ImageField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.FILE.type:
          return (
            <FileField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.TRANSLATED_FILE.type:
          return (
            <TranslatedFileField
                field={this.state.field}
                hideTab={true}
                onFileSelect={this.onTranslatedFileSelect.bind(this)}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.DATE.type:
          return (
            <DateField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.IMAGES.type:
          return (
            <ImagesField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
                onImageSelect={this.props.onImageSelect}
            />
          );
        case FIELDS.CONTENTS.type:
          return (
            <ContentsField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
                onContentSelect={this.props.onContentSelect}
            />
          );
        case FIELDS.BOOLEAN.type:
          return (
            <BooleanField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.LINK.type:
          return (
            <LinkField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
                onContentSelect={this.props.onContentSelect}
            />
          );

        case FIELDS.VIDEO.type:
          return (
            <VideoField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );
        case FIELDS.LOCALIZATION.type:
          return (
            <LocalizationField
                field={this.state.field}
                hideTab={true}
                onFieldChange={this.onFieldChange}
            />
          );



        case "widget":
            const Widget = this.widgets[this.state.field.component || 'CommonWidget'];
            return <Widget
                field={this.state.field}
                hideTab={true}
                onWidgetChange={this.onWidgetChange.bind(this)}
            />

        case "widget-list":

          return (
            <ListWidget
              field={this.state.field}
              hideTab={true}
            />
          );

      default :
        return null;
    }
  }


  /**************** MODAL LIST *******************/

  handleListItemChange(field) {

    var stateField = this.state.field;
    const listItemInfo = this.props.modalEditList.item;

    stateField.value[listItemInfo.index] = field;

    //update the field used to comunicate between the ListWidget and the Modal
    listItemInfo.field = field;

    ////console.log("ModalEditItem :: handleListItemChange :: listItemInfo => ",this.state.listItemInfo);
    ////console.log("ModalEditItem :: handleListItemChange => ",stateField);

    this.setState({
        field : stateField,
        listItemInfo : listItemInfo
    });

    this.props.changePageField(
      stateField,
      this.props.modalEdit.item.pathToIndex,
      this.props.app.layout
    )
  }

  /*************** SETTINGS **********************/

  handleFieldSettingsChange(field) {

      ////console.log("ModalEditItem :: handleFieldSettingsChange => ", field);

      const stateField = this.state.field;

      //update field settings to be same structure as field ( field.settings[name] = value )
      stateField[field.source][field.name] = field.value;

      this.setState({
          field : stateField
      });

      this.props.changePageField(
        stateField,
        this.props.modalEdit.item.pathToIndex,
        this.props.app.layout
      )

      if(field.name == "fileElements" || field.name == "tableElements"
        || field.name == "formElements"
        || field.name == "formElementsV2"
        || field.name == "formElementsV2Preload"
        || field.name == "hiddenFilter"
        || field.name == "conditionalVisibility") {

          console.log("handleFieldSettingsChange :: update parameters!");

        this.updateParameters(field);
      }
  }

  updateParameters(field) {

    console.log("updateParameters :: field => ",field);

    if(field == null){
      return null;
    }

    field[field.source] = {};
    field[field.source][field.name] = field.value;

    //get parameters of this field.value
    var parameters = this.getFieldParameters(field);
    var templates = this.getElementTemplates(field);
    console.log("updateParameters :: parameters => ",parameters);
    //console.log("update parameters! :: (parameters) => ",parameters);

    var self = this;

    this.setState({
      parameters : parameters,
      templates : templates
    },function(){
        //update page parameters with this new parameters
        self.props.updateParameters(
          self.props.app.layout,
          self.props.modalEdit.originalElements,
          self.props.app.parameters,
          self.props.app.parametersList,
        );
    });

    
  }

  getElementParameters(field) {
    if(field.value == null)
      return null;

    var elementsList = this.props.modalEdit.fileElements;

    if(field.name == "tableElements"){
      elementsList = this.props.modalEdit.tableElements;
    }
    else if(field.name == "formElements"){
      elementsList = this.props.modalEdit.formElements;
    }
    else if(field.name == "formElementsV2"){
      elementsList = this.props.modalEdit.formElementsV2;
    }

    //console.log("update parameters! :: elementsList => ",elementsList);

    for(var i=0;i<elementsList.length;i++){
      var element = elementsList[i];
      if(element.value == field.value){
        return element.parameters;
      }
    }    

    return null;
  }

  getElementTemplates(field) {

    architect.log('ModalEditItem :: getElementTemplates : (field) ',field);

    var elementId = null;
    if(field.settings['fileElements'] !== undefined){
      elementId = field.settings['fileElements'];
    }
    else if(field.settings['tableElements'] !== undefined){
      elementId = field.settings['tableElements'];
    }
    else if(field.settings['formElements'] !== undefined){
      elementId = field.settings['formElements'];
    }
    else if(field.settings['formElementsV2'] !== undefined){
      elementId = field.settings['formElementsV2'];
    }

    if(elementId == null)
      return [];

    var elementsList = this.props.modalEdit.originalElements;

    for(var i=0;i<elementsList.length;i++){
      var element = elementsList[i];
      if(elementId == element.id){

        architect.log('ModalEditItem :: selected templates : ',element.templates);

        return element.templates;
      }
    }    
    return [];
  }

  getCropsformats() {
      var formats = [];
      IMAGES_FORMATS.map(function(format, k){
          formats.push({
              name : format.name+" ("+format.width+"x"+format.height+")",
              value : format.name
          });
      });

      return formats;
  }

  getTemplateOptions() {
    var options = [{
      name : "---",
      value : ""
    }];
    
    for(var key in this.state.templates){
      options.push({
        value: this.state.templates[key].id,
        name: this.state.templates[key].name
      })
    }

    return options;
  }

  renderParameters() {
    if(this.state.parameters == null || this.state.parameters.length == 0 ||
      this.props.modalEdit == null || this.props.modalEdit.parameters === undefined){
      return (
          <div className="parameter">
            Aucun paramètre trouvé
          </div>
      )
    }
    return this.state.parameters.map((item,index) => {

      if(this.props.modalEdit.parameters[item.id] === undefined)
        return null;

      return (
        <div className="parameter" key={index} style={{display:"inline-block"}}>
          {index != 0 &&
              <span>, &nbsp;</span>
          }
          {this.props.modalEdit.parameters[item.id].name}
        </div>
      );
    })
  }

  renderSettings() {

    ////console.log("renderSettings!",this.state.field);

    return (
      <div>

        <h6>{Lang.get('modals.configuration')}</h6>


        <SelectorSettingsField
          field={this.state.field}
          name="fileElements"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.element')}
          options={this.props.modalEdit.fileElements.map(function(obj){
              return {
                  value: obj.value,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="tableElements"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.element')}
          options={this.props.modalEdit.tableElements.map(function(obj){
              return {
                  value: obj.value,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="formElements"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.element')}
          options={this.props.modalEdit.formElements.map(function(obj){
              return {
                  value: obj.value,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="formElementsV2Preload"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={'Formulaire de précharge'}
          options={this.props.modalEdit.formElementsV2.map(function(obj){
              return {
                  value: obj.value,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="formElementsV2"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.element')}
          options={this.props.modalEdit.formElementsV2.map(function(obj){
              return {
                  value: obj.value,
                  name: obj.name
              };
          })}
        />

        {this.state.templates != null && 
          <SelectorSettingsField
            field={this.state.field}
            name="template"
            source="settings"
            onFieldChange={this.handleFieldSettingsChange.bind(this)}
            label={'Sélectionner template'}
            options={this.getTemplateOptions()}
          />
        }

        {this.state.parameters !== undefined && this.state.parameters != null &&
          <div>
            <label>Paramètres</label>
            <div>
              {this.renderParameters()}
            </div>
            <hr/>
          </div>
        }

        <InputTranslatedSettingsField
          field={this.state.field}
          name="title"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.title')}
          inputLabel={Lang.get('modals.indica_title')}
          translations={this.props.translations}
        />

        <InputSettingsField
          field={this.state.field}
          name="htmlId"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label="Html ID"
          inputLabel={Lang.get('modals.indica_html')}
        />

        <InputSettingsField
          field={this.state.field}
          name="htmlClass"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label="Html Class"
          inputLabel={Lang.get('modals.indica_css')}
        />

        <InputSettingsField
          field={this.state.field}
          name="backgroundColor"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label="Couleur de fond"
          inputLabel="Entrez la couleur"
        />

        <InputSettingsField
          field={this.state.field}
          name="backgroundHoverColor"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label="Couleur de fond (Hover)"
          inputLabel="Entrez la couleur"
        />
        

        <BooleanSettingsField
          field={this.state.field}
          name="collapsable"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.collapsable')}
        />

        <BooleanSettingsField
          field={this.state.field}
          name="collapsed"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.collapsed')}
        />

        <BooleanSettingsField
          field={this.state.field}
          name="doubleColumn"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.doubleColumn')}
        />


        <BooleanSettingsField
          field={this.state.field}
          name="header"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.header')}
        />

        <BooleanSettingsField
          field={this.state.field}
          name="excel"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.excel')}
        />

        <RadioSettingsField
          field={this.state.field}
          name="cropsAllowed"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.sizes_allowed')}
          options={this.getCropsformats()}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="typologyAllowed"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.tipology_allowed')}
          options={this.props.modalEdit.typologies.map(function(obj){
              return {
                  value: obj.id,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="typology"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.typology_allowed')}
          options={this.props.modalEdit.listableTypologies.map(function(obj){
              return {
                  value: obj.id,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="selectableTypology"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.tipology')}
          options={this.props.modalEdit.selectableTypologies.map(function(obj){
              return {
                  value: obj.id,
                  name: obj.name
              };
          })}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="category"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.category')}
          options={this.props.modalEdit.categories}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="maxItems"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.max_elements')}
          //inputLabel={Lang.get('modals.indica_max_elements_page')}
          options={[
              {
                  value: "",
                  name: "Désactivé",
              },
              {
                  value: 5,
                  name: "5",
              },
              {
                  value: 10,
                  name: "10",
              },
              {
                  value: 20,
                  name: "20",
              },
              {
                  value: 25,
                  name: "25",
              },
              {
                  value: 50,
                  name: "50",
              },
              {
                  value: 100,
                  name: "100",
              }
          ]}
        />

        <InputSettingsField
          field={this.state.field}
          name="itemsPerPage"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.max_elements_page')}
          inputLabel={Lang.get('modals.indica_max_elements_page')}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="pagination"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.pagination')}
          //inputLabel={Lang.get('modals.indica_max_elements_page')}
          options={[
              {
                  value: "",
                  name: "Désactivé",
              },
              {
                  value: 5,
                  name: "5",
              },
              {
                  value: 10,
                  name: "10",
              },
              {
                  value: 20,
                  name: "20",
              },
              {
                  value: 25,
                  name: "25",
              },
              {
                  value: 50,
                  name: "50",
              },
              {
                  value: 100,
                  name: "100",
              }
          ]}
        />
        <InputSettingsField
          field={this.state.field}
          name="textIdentifier"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.search_field')}
          inputLabel={Lang.get('modals.indica_tipology_text_identifier')}
        />

        <InputSettingsField
          field={this.state.field}
          name="dateIdentifier"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.date_field')}
          inputLabel={Lang.get('modals.indica_tipology_date_identifier')}
        />

        <BooleanSettingsField
          field={this.state.field}
          name="extended"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.extended_version')}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="columns"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.list_columns')}
          options={[
              {
                  value: "",
                  name: "---",
              },
              {
                  value: "col-1",
                  name: "1 "+Lang.get('modals.column'),
              },
              {
                  value: "col-2",
                  name: "2 "+Lang.get('modals.columns'),
              },
              {
                  value: "col-3",
                  name: "3 "+Lang.get('modals.columns'),
              },
              {
                  value: "col-4",
                  name: "4 "+Lang.get('modals.columns'),
              }
          ]}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="bootstrapColumns"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.list_columns')}
          options={[
              {
                  value: "",
                  name: "---",
              },
              {
                  value: "col-md-12",
                  name: "1 "+Lang.get('modals.column'),
              },
              {
                  value: "col-md-6",
                  name: "2 "+Lang.get('modals.columns'),
              },
              {
                  value: "col-md-4",
                  name: "3 "+Lang.get('modals.columns'),
              },
              {
                  value: "col-md-3",
                  name: "4 "+Lang.get('modals.columns'),
              }
          ]}
        />

        <InputSettingsField
          field={this.state.field}
          name="height"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.height')}
          inputLabel={Lang.get('modals.indica_height')}
        />


        <HiddenFilter
          field={this.state.field}
          name="hiddenFilter"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={'Filtrer pour cacher'}
          inputLabel={'Si la variable a cette valeur est caché'}
        />

        <VisibilitySettingsField
          field={this.state.field}
          name="conditionalVisibility"
          source="settings"
          inputLabel="Définir l'état par défaut."
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label="Afficher selon conditions"
          parameters={this.props.app.parametersList}
        />

        <SelectorSettingsField
          field={this.state.field}
          name="buttonClass"
          source="settings"
          onFieldChange={this.handleFieldSettingsChange.bind(this)}
          label={Lang.get('modals.button_class')}
          options={[
              {
                  value: "",
                  name: Lang.get('modals.button_primary'),
              },
              {
                  value: "box-button-secondary",
                  name: Lang.get('modals.button_secondary'),
              }
          ]}
        />
      </div>


    );


  }



  render() {

    ////console.log("ModalEditItem :: render field => ",this.state.field);

    return (
      <div>

        <ModalEditListItem
          onUpdateData={this.handleListItemChange.bind(this)}
          zIndex={9500}
        />

        <div className="custom-modal" id="modal-edit-item" style={{zIndex:this.props.zIndex}}>
          <div className="modal-background"></div>


            <div className="modal-container">

              {this.state.field != null &&
                <div className="modal-header">

                    <i className={"fa "+this.state.field.icon}></i>
                    <h2>{this.state.field.name} | {Lang.get('modals.edition')}</h2>

                  <div className="modal-buttons">
                    <a className="btn btn-default close-button-modal" onClick={this.onModalClose}>
                      <i className="fa fa-times"></i>
                    </a>
                  </div>
                </div>
              }

              <div className="modal-content">
                <div className="container">
                  <div className="row">
                    <div className="col-xs-7 field-col">

                      {this.state.field != null &&
                        this.renderField()}

                    </div>
                    <div className={"col-xs-5 settings-col "+(architect.currentUserHasRole(ROLES['ROLE_ADMIN']) ? "disabled":"")}>
                      {this.renderSettings()}
                    </div>
                  </div>
                </div>

                <div className="modal-footer">
                  <a href="" className="btn btn-default" onClick={this.onModalClose}> {Lang.get('modals.cancel')} </a> &nbsp;
                  <a href="" className="btn btn-primary" onClick={this.onSubmit.bind(this)}> {Lang.get('modals.accept')} </a> &nbsp;
                </div>

              </div>
          </div>
        </div>
      </div>
    );
  }

}


const mapStateToProps = state => {
    return {
        app: state.app,
        modalEdit : state.modalEdit,
        modalEditList : state.modalEditList
    }
}

const mapDispatchToProps = dispatch => {
    return {
        initEditItem : (payload) => {
            return dispatch(initEditItem(payload));
        },
        editItem: (item) => {
            return dispatch(editItem(item));
        },
        cancelEditItem: () => {
            return dispatch(cancelEditItem());
        },
        changePageField: (field,pathToIndex,layout) => {
            return dispatch(changePageField(field,pathToIndex,layout));
        },
        loadCategories : () => {
            return dispatch(loadCategories())
        },
        loadElements : () => {
            return dispatch(loadElements())
        },
        loadParameters : () => {
          return dispatch(loadParameters())
        },
        updateParameters : (definition, elements, pageParameters, parametersList) => {
          return dispatch(updateParameters(definition, elements, pageParameters, parametersList))
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ModalEditItem);
