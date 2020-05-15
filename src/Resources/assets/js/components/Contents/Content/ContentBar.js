import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  duplicate,
  deleteContent,
  submitForm,
  saveLayout,
  selectLayout
} from './../actions/';

class ContentBar extends Component {

  constructor(props){
    super(props);

    //console.log("props.app => ",props.app);

    if(props.app.typology.id != null){
      this.createRoute = routes['contents.create'].replace(':id',props.app.typology.id);
    }
    else {
      this.createRoute = routes['contents.page.create'];
    }

  }

  saveLayout(e) {
      e.preventDefault();
      this.props.onLayoutSave != undefined ? this.props.onLayoutSave() : null;

      var self = this;

      bootbox.prompt(Lang.get('modals.name_template'), function(result){
        if(result != null){
          self.props.saveLayout(result,
            self.props.app.layout,
            self.props.app.settings
          );
        }
      });

  }

  loadLayout(e) {
      e.preventDefault();
      this.props.selectLayout();
  }

  getFormData() {

      ////console.log("app => ",this.props.app);
      const isPage = this.props.app.typology ? false : true;
      const app = this.props.app;

      var data = {
        parent_id: app.parent_id,
        translations : app.translations,
        content_id : app.content !== undefined ? app.content.id : null,
        status : app.status,
        category_id : app.category,
        tags : app.tags,
        settings : app.settings,
      }

      //merge different fields for page and content
      if(isPage) {
        return {
          ...data,
          /*
          fields : {
              title : app.title,
              slug : app.slug,
              description : app.description
          },
          */
          fields : app.fields,
          is_page : true,
          page: app.layout,
          parameters : app.parameters
        };
      }
      else {
        return {
          ...data,
          fields : app.fields,
          typology_id : app.typology.id,
        }
      }

  }

  renderUnsavedMenu(isPage) {

    return (
      <ul className="dropdown-menu dropdown-menu-right default-padding">
          <li className="dropdown-header"></li>
          <li>
              <a href={this.createRoute}>
                  <i className="fa fa-plus-circle"></i>
                  &nbsp;{Lang.get('fields.new')}
              </a>
          </li>
          {isPage &&
            <li>
                <a href="#" onClick={this.loadLayout.bind(this)}>
                    <i className="fa fa-download"></i>
                    &nbsp;{Lang.get('modals.load_template')}
                </a>
            </li>
          }
      </ul>
    );
  }

  renderFullMenu() {

    return (
      <ul className="dropdown-menu dropdown-menu-right default-padding">
          <li className="dropdown-header"></li>
          <li>
              <a href={this.createRoute}>
                  <i className="fa fa-plus-circle"></i>
                  &nbsp;{Lang.get('fields.new')}
              </a>
          </li>

          <li>
              <a href="#" onClick={this.onDuplicate.bind(this)}>
                  <i className="fa fa-files-o"></i>
                  &nbsp;{Lang.get('fields.duplicate')}
              </a>
          </li>

          <li>
              <a href="#" onClick={this.loadLayout.bind(this)}>
                  <i className="fa fa-download"></i>
                  &nbsp;{Lang.get('modals.load_template')}
              </a>
          </li>

          <li>
              <a href="#" onClick={this.saveLayout.bind(this)}>
                  <i className="fa fa-upload"></i>
                  &nbsp;{Lang.get('modals.save_template')}
              </a>
          </li>

          <li>
              <a href="#" className="text-danger" onClick={this.onDelete.bind(this)}>
                  <i className="fa fa-trash text-danger"></i>
                  &nbsp;
                  <span className="text-danger">{Lang.get('fields.delete')}</span>
              </a>
          </li>
      </ul>
    );

  }

  onSubmitForm(e) {
    e.preventDefault();

    if(!this.props.app.saving){
      this.props.submitForm(this.getFormData());
    }
  }

  onDuplicate(e) {
    e.preventDefault();

    if(!this.props.app.saving){
      this.props.duplicate(this.props.app.content.id)
    }
  }

  onDelete(e) {
    e.preventDefault();

    if(!this.props.app.saving){
      this.props.deleteContent(this.props.app.content.id,this.getFormData());
    }
  }

  getPageParams() {
    const isPage = this.props.app.typology ? false : true;

    if(!isPage) {
      return "";
    }
    else{

      const params = this.props.app.parameters;
      if(params === undefined || params.length == 0)
        return "";

      var result = "?";
      var first = true;
      for(var i=0;i<params.length;i++){
        result += (!first? '&':'')+params[i].identifier+"="+params[i].default;
        first = false;
      }
    }

    return result;
  }

  render() {

    const isPage = this.props.app.typology ? false : true;

    const icon = isPage ? 'far fa-file' : this.props.app.typology.icon;
    const name = isPage ? Lang.get('fields.page') : this.props.app.typology.name;
    const saved = this.props.app.saved;
    const hasPreview = isPage ? true : (
      this.props.app.typology.has_slug == 1 ? true : false
    );
    const content = this.props.app.content;
    const saving = this.props.app.saving;

    const params = this.getPageParams();

    return (
      <div className="page-bar">
        <div className="container">
          <div className="row">

            <div className="col-md-12">
              <a href={routes.contents} className="btn btn-default"> <i className="fa fa-angle-left"></i> </a>
              <h1>
                {icon != "" &&
                  <i className={icon}></i>
                }
                {'\u00A0'}

                { name != "" ? name : Lang.get('modals.new_content') }
              </h1>

              <div className="float-buttons pull-right">


                {!architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&

                  <div className="actions-dropdown">
                    <a href="#" className="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false">
                      {Lang.get('fields.actions') }
                      <b className="caret"></b>
                      <div className="ripple-container"></div>
                    </a>
                      { saved && content !== undefined && content != null && !architect.currentUserHasRole(ROLES['ROLE_ADMIN']) &&
                        this.renderFullMenu()
                      }

                      { !saved  &&
                        this.renderUnsavedMenu(isPage)
                      }
                  </div>
                }

              {  saved && content !== undefined && content != null &&
                hasPreview &&
                <a href={routes['previewContent'].replace(':id',content.id)+params} target="_blank" className="btn btn-default" > <i className="fa fa-eye"></i> &nbsp; {Lang.get('fields.preview') } </a>
              }
              <a href="" className="btn btn-primary"
                onClick={this.onSubmitForm.bind(this)}
                disabled={saving}
              > <i className="fa fa-cloud-upload"></i> &nbsp; {Lang.get('fields.save') } </a>
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
        modalLayout : state.modalLayout
    }
}

const mapDispatchToProps = dispatch => {
    return {
        duplicate: (contentId) => {
            return dispatch(duplicate(contentId));
        },
        deleteContent: (contentId, data) => {
          return dispatch(deleteContent(contentId, data));
        },
        submitForm: (data) => {
          return dispatch(submitForm(data));
        },
        saveLayout: (name,layout,settings) => {
          return dispatch(saveLayout(name,layout,settings));
        },
        selectLayout : () => {
          return dispatch(selectLayout());
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ContentBar);
