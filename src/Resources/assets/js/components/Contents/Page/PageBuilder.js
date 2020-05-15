import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  addRow,
  cancelImage,
  updatePageImage,
  updateSelectedContent,
  cancelContent,
  updatePageContent,
  updateParameters
} from './../actions/';

import ContentFields from './../Content/ContentFields';
import FirstEmptyRow from './RowTypes/FirstEmptyRow';
import Row from './RowTypes/Row';
import ModalSelectItem from './ModalSelectItem';
import ModalEditClass from './ModalEditClass';
import ModalEditItem from './ModalEditItem';
import MediaSelectModal from './../../Medias/MediaSelectModal';
import ContentSelectModal from './../ContentSelectModal';
import LayoutSelectModal from './LayoutSelectModal';

class PageBuilder extends Component {

  constructor(props){
    super(props);

    this.loaded = false;
  }

  handleAddRow(e) {
    e.preventDefault();

    this.props.addRow(this.props.app.layout);

  }

  renderRows() {

    const {layout} = this.props.app;

    return (
        layout.map((item,index) =>
          <Row
            index={index}
            key={index}
            data={item}
            pathToIndex={[parseInt(index)]}
            childrenLength={layout.length}
          />
        )
    );

  }

  componentWillReceiveProps(nextProps) {
    console.log("PageBuilder :: ",nextProps.app);

    if(!this.loaded && nextProps.app.loaded){
      //app is loaded

      //console.log("PageBuilder :: first update parameters");

      this.props.updateParameters(
        nextProps.app.layout,
        nextProps.modalEdit.originalElements,
        nextProps.app.parameters,
        nextProps.app.parametersList,
      );

      this.loaded = true;
    }
  }

  handleImageSelected(media){

      this.props.updatePageImage(
        media,
        this.props.images.sourceField,
        this.props.modalEdit.item.pathToIndex,
        this.props.app.layout,
        this.props.images.sourceLanguage,
        this.props.modalEdit.item.data.field,
        this.props.modalEditList.item
      );
  }

  handleImageCancel(){
    this.props.cancelImage();
  }

  handleContentSelected(content){
      this.props.updatePageContent(
        content,
        this.props.contents.sourceField,
        this.props.modalEdit.item.pathToIndex,
        this.props.app.layout,
        this.props.modalEdit.item.data.field,
        this.props.modalEditList.item
      );
  }

  handleContentCancel(){
    this.props.cancelContent();
  }

  render() {
    const fields = this.props.app.fields;
    const contentSourceField = this.props.contents.sourceField;
    const mediaType = this.props.images.sourceField != null ?
      this.props.images.sourceField.type : null;

    return (
      <div className="col-xs-9 page-content page-builder">

        <ModalSelectItem
          zIndex={9000}
        />

        <ModalEditClass
          zIndex={9000}
        />

        <LayoutSelectModal
          zIndex={9000}
        />

        <MediaSelectModal
          display={this.props.images.displayModal}
          field={this.props.images.sourceField}
          mediaType={mediaType}
          onImageSelected={this.handleImageSelected.bind(this)}
          onImageCancel={this.handleImageCancel.bind(this)}
        />

        <ContentSelectModal
          display={this.props.contents.displayModal}
          field={contentSourceField != null && fields != null ? fields[contentSourceField] : null}
          onContentSelected={this.handleContentSelected.bind(this)}
          onContentCancel={this.handleContentCancel.bind(this)}
        />

        <ModalEditItem
          zIndex={9000}
        />

        <ContentFields />

        <div className="field-group">
          {this.props.app.layout != null &&
            this.renderRows()
          }

          {!architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
            <FirstEmptyRow
                onAddRow={this.handleAddRow.bind(this)}
            />
          }
        </div>
      </div>
    );
  }

}


const mapStateToProps = state => {
    return {
        app: state.app,
        modalItem : state.modalItem,
        modalEdit : state.modalEdit,
        images : state.images,
        contents : state.contents,
        modalEditList : state.modalEditList
    }
}

const mapDispatchToProps = dispatch => {
    return {
        addRow: (layout) => {
            return dispatch(addRow(layout));
        },
        cancelImage : () => {
            return dispatch(cancelImage());
        },
        updatePageImage : (media,field,pathToIndex,layout,language, editItem,listItemInfo) => {
            return dispatch(updatePageImage(media,field,pathToIndex,layout,language, editItem,listItemInfo));
        },
        cancelContent: () => {
            return dispatch(cancelContent());
        },
        updateSelectedContent: (field,content,fields) => {
            return dispatch(updateSelectedContent(field,content,fields));
        },
        updatePageContent : (content,field,pathToIndex,layout,editItem,listItemInfo) => {
            return dispatch(updatePageContent(content,field,pathToIndex,layout,editItem,listItemInfo));
        },
        updateParameters : (definition, elements, pageParameters, parametersList) => {
            return dispatch(updateParameters(definition, elements, pageParameters, parametersList))
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(PageBuilder);
