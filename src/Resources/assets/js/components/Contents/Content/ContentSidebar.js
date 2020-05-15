import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  changeField,
  changeSettings,
  publishToogle,
  changeTranslation,
  updateDefaultParameters
} from './../actions/';

import TagManager from "./../Tags/TagManager";
import InputSettingsField from './../../Typology/Settings/InputSettingsField';
import SelectorSettingsField from './../../Typology/Settings/SelectorSettingsField';

import moment from 'moment';

class ContentSidebar extends Component {

  constructor(props) {
    super(props);

    ////console.log('PROPS ======>', props);

    this.handleChange = this.handleChange.bind(this);
    this.handleTranslationChange = this.handleTranslationChange.bind(this);
  }

  handleChange(event) {

    var field = null;

    if(event.target.type == "text" || event.target.type == "select-one"){
        field = {
            name : event.target.name,
            value : event.target.value
        };
    }
    else if(event.target.type == "checkbox"){
        field = {
            name : event.target.name,
            value : event.target.checked
        };
    }

    if(field != null) {
        this.props.changeField(field);
    }

  }

  componentWillReceiveProps(nextProps) {
    console.log("ContentSidebar :: nextProps => ",nextProps);
  }

  handleTranslationChange(event) {
    var field = {
      name : event.target.name,
      value : event.target.checked
    };

    this.props.changeTranslation(field);
  }

  renderLanguagesCheckbox()
  {
    return (LANGUAGES.map((language, k) => (
        <div className="togglebutton" key={k}>
            <label>
              {language.name}
              {language.iso == DEFAULT_LOCALE &&
                <input type="checkbox" name={language.iso} value={true} checked="true" disabled="true" />
              }
              {language.iso != DEFAULT_LOCALE &&
                <input type="checkbox" name={language.iso} checked={this.props.app.translations[language.iso]} onChange={this.handleTranslationChange} />
              }
            </label>
        </div>
    )));
  }

  printSpace(level)
  {

    if(level <= 1)
      return null;

    var spaces = [];
    for(var i=1;i<level;i++){
      spaces.push(
        "- "
      );
    }

    return spaces;
  }

  handleFieldSettingsChange(field) {

      ////console.log("ModalEditItem :: handleFieldSettingsChange => ", field);

      const settings = this.props.app.settings;

      settings[field.name] = field.value;

      this.props.changeSettings(settings);
  }

  handlePublish(e) {

      e.preventDefault();

      const newStatus = 1;

      this.props.publishToogle(this.props.app.content.id,newStatus);
  }

  handleUnpublish(e) {

      e.preventDefault();

      const newStatus = 0;

      this.props.publishToogle(this.props.app.content.id,newStatus);
  }

  renderSettings()
  {

    //console.log("settings => ",this.props.app.settings)

    const field = {
      settings : this.props.app.settings
    };

    return (
      <div>
        <div className="form-group bmd-form-group sidebar-item">
          <SelectorSettingsField
            field={field}
            name="pageType"
            source="settings"
            onFieldChange={this.handleFieldSettingsChange.bind(this)}
            label={Lang.get('fields.page_type')}
            options={[
              {
                value : '',
                name : '---'
              },
              {
                value : 'single',
                name : 'Single'
              },
              {
                value : 'landing',
                name : 'Landing'
              },
              {
                value : 'home',
                name : 'Home'
              }
            ]}
          />
        </div>
        <div className="form-group bmd-form-group sidebar-item">
          <InputSettingsField
            field={field}
            name="htmlClass"
            source="settings"
            onFieldChange={this.handleFieldSettingsChange.bind(this)}
            label={Lang.get('modals.html_class')}
            inputLabel={Lang.get('modals.indica_html')}
          />
        </div>

      </div>


    )
  }

  handleParameterDefaultChange(index,event) {
    event.preventDefault();

    console.log("handleParameterDefaultChange ::");

    const parameters = this.props.app.parameters;

    parameters[index].default = event.target.value;

    this.props.updateDefaultParameters(parameters);
  }

  isRequired(settings) {
    if(settings !== undefined && settings != null &&
      settings['required'] !== undefined && settings['required'] != null){
      return settings['required'];
    }

    return true;
  }

  renderParameters() {

    const parameters = this.props.app.parameters;

    if(parameters === undefined || parameters == null){
        return null;
    }

    return parameters.map((item,index) => {

      const required = this.isRequired(item.settings);

      return (
        <div className="form-group bmd-form-group" key={index}>
          <label htmlFor={item.id} className="bmd-label-floating">
            {required &&
              <i className="fas fa-exclamation-circle"></i>

            }
            {!required &&
              <i className="far fa-question-circle"></i>
            }
            &nbsp; {item.name}
          </label>
          <input
            id={item.id} className="form-control"
            value={item.default}
            placeholder="Valeur de prévisualisation"
            name={item.identifier}
            onChange={this.handleParameterDefaultChange.bind(this,index)}
          />
        </div>
      )
    });
  }

  render() {

    var self = this;

    const isPage = this.props.app.typology ? false : true;

    return (
      <div className="sidebar">
        { this.props.app.saved &&
          <div className="publish-group">
            { this.props.app.status == 1 &&
              <div className="publish-form sidebar-item">
                  <i className="fa fa-circle text-success"></i> {Lang.get('fields.published')} <br/>
                  {!architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
                    <a className="btn btn-default" href="" onClick={this.handleUnpublish.bind(this)}> {Lang.get('fields.unpublish')} </a>
                  }
                  <p className="field-help">{moment(this.props.app.content.published_at).format('LLLL')}</p>
              </div>
            }

            {this.props.app.status == 0 &&
              <div className="publish-form sidebar-item">
                  <i className="fa fa-circle text-warning"></i> {Lang.get('fields.draft')} <br/>
                  {!architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
                    <a className="btn btn-success" href=""  onClick={this.handlePublish.bind(this)}> {Lang.get('fields.publish')} </a>
                  }
                  <p className="field-help"></p>
              </div>
            }

            <hr/>

          </div>
        }

        {isPage &&
          <div>
            <h3>Parametres</h3>
            {this.renderParameters()}
            <hr/>
          </div>
        }

        <div className="form-group bmd-form-group sidebar-item">
           <label className="bmd-label-floating">{Lang.get('fields.active_languages')}</label>
           {this.renderLanguagesCheckbox()}
        </div>

        <hr/>

        {this.props.app.pages !== undefined && this.props.app.pages != null &&
          <div>
            <div className="form-group bmd-form-group sidebar-item">
               <label htmlFor="parent_id" className="bmd-label-floating">{Lang.get('fields.parent_page')}</label>

               {!architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
                 <select className="form-control" id="parent_id" name="parent_id" value={this.props.parent_id}  onChange={this.handleChange}>
                      <option value="">---</option>
                     {
                       this.props.app.pages && Object.keys(this.props.app.pages).map(function(id) {
                           return <option value={self.props.app.pages[id].id} key={self.props.app.pages[id].id} selected={self.props.app.content && self.props.app.content.parent_id == self.props.app.pages[id].id ? "selected" : ""}>{self.props.app.pages[id].title}</option>
                       })
                     }
                 </select>
               }
               {architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
                 <select disabled="true" className="form-control" id="parent_id" name="parent_id" value={this.props.parent_id}  onChange={this.handleChange}>
                      <option value="">---</option>
                     {
                       this.props.app.pages && Object.keys(this.props.app.pages).map(function(id) {
                           return <option value={self.props.app.pages[id].id} key={self.props.app.pages[id].id} selected={self.props.app.content && self.props.app.content.parent_id == self.props.app.pages[id].id ? "selected" : ""}>{self.props.app.pages[id].title}</option>
                       })
                     }
                 </select>
               }

            </div>
            <hr/>
          </div>
        }

        {this.props.app.typology.has_categories == 1 &&
          <div>
            <div className="form-group bmd-form-group has-danger">
               <label htmlFor="template" className="bmd-label-floating">{Lang.get('fields.category')}</label>
               <select className="form-control" id="template" name="category" value="" value={this.props.app.category} onChange={this.handleChange}>
                    <option value="">---</option>
                   {
                     this.props.app.categories && this.props.app.categories.map(function(category, i) {
                       return <option value={category.id} key={i}>{self.printSpace(category.level)}{category.name}</option>
                     })
                   }
               </select>
            </div>
            <hr/>
          </div>
        }

        {this.props.app.typology.has_tags  == 1 &&
          <div>
            <div className="form-group bmd-form-group sidebar-item">
              <TagManager
                tags={this.props.app.tags}
                tagsList={this.props.app.tagsList}
                content={this.props.app.content}
              />
            </div>

            <hr/>
          </div>
        }

        {this.props.app.settings !== undefined && !architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&

          <div>
            <hr/>

            <div className="sidebar-item">
               <label className="bmd-label-floating">{Lang.get('header.configuration')}</label>
               {this.renderSettings()}
            </div>


          </div>
        }


      </div>
    );
  }

}



const mapStateToProps = state => {
    return {
        app: state.app
    }
}

const mapDispatchToProps = dispatch => {
    return {
        changeField: (field) => {
            return dispatch(changeField(field));
        },
        changeSettings: (settings) => {
            return dispatch(changeSettings(settings));
        },
        publishToogle : (contentId, status) => {
            return dispatch(publishToogle(contentId, status));
        },
        changeTranslation : (field) => {
            return dispatch(changeTranslation(field));
        },
        updateDefaultParameters : (parameters) => {
            return dispatch(updateDefaultParameters(parameters));
        },
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ContentSidebar);
