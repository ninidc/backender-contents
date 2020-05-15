import React, {Component} from 'react';
import { render } from 'react-dom';
import {connect} from 'react-redux';

import {
  submitForm
} from './actions/';

class FormBar extends Component {

  constructor(props){
    super(props);

  }

  getFormData() {
      return {
        id : this.props.app.form.id,  //set with id if set
        name : this.props.app.form.identifier,  //set with form name
        fields : this.props.app.fields
      };
  }

  onSubmitForm(e) {
    e.preventDefault();

    if(!this.props.app.saving){
      this.props.submitForm(this.getFormData());
    }
  }



  onDelete(e) {
    e.preventDefault();

    if(!this.props.app.saving){
      this.props.deleteContent(this.props.app.content.id,this.getFormData());
    }
  }


  renderUnsavedMenu(isPage) {

    return null;
  }

  renderFullMenu() {

    return (
      <ul className="dropdown-menu dropdown-menu-right default-padding">
          <li className="dropdown-header"></li>
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

  render() {

    const icon = 'far fa-file';
    const name = 'Form';
    const saved = this.props.app.saved;
    const saving = this.props.app.saving;

    return (
      <div className="page-bar">
        <div className="container">
          <div className="row">

            <div className="col-md-12">
              <a href={routes.styles} className="btn btn-default"> <i className="fa fa-angle-left"></i> </a>
              <h1>
                  {icon != "" &&
                    <i className={icon}></i>
                  }
                  {'\u00A0'}

                  { name != "" ? name : Lang.get('modals.new_content') }
              </h1>

              <div className="float-buttons pull-right">

                { saved &&
                  <div className="actions-dropdown">

                    <a href="#" className="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false">
                      {Lang.get('fields.actions') }
                      <b className="caret"></b>
                      <div className="ripple-container"></div>
                    </a>

                        this.renderFullMenu()
                  </div>
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
        submitForm: (data) => {
          return dispatch(submitForm(data));
        }

    }
}

export default connect(mapStateToProps, mapDispatchToProps)(FormBar);
