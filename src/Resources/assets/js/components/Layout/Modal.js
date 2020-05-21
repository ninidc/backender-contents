import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

export default class Modal extends Component {

  constructor(props) {
    super(props);

    this.state = {

    };

    this.onModalClose = this.onModalClose.bind(this);
  }

  componentDidMount() {

    if (this.props.display) {
      this.modalOpen();
    }

  }

  componentDidUpdate(prevProps, prevState) {

    if (!prevProps.display && this.props.display) {
      this.modalOpen();

    } else if (prevProps.display && !this.props.display) {
      this.modalClose();
    }

  }

  onModalClose(e) {
    e.preventDefault();
    this.props.onModalClose();
  }

  modalOpen() {
    TweenMax.to($("#" + this.props.id), 0.5, { opacity: 1, display: "block", ease: Power2.easeInOut });
  }

  modalClose() {

    var self = this;
    TweenMax.to($("#" + this.props.id), 0.5, {
      display: "none", opacity: 0, ease: Power2.easeInOut, onComplete: function () {

      }
    });
  }

  onSubmit(e) {
    e.preventDefault();
    this.props.onSubmit();
  }

  onRemove(e){
    e.preventDefault();

    var _this = this;

    bootbox.confirm({
      message: this.props.rempoveMessage !== undefined ? 
      this.props.rempoveMessage : Lang.get('fields.delete_row_alert'),
      buttons: {
          confirm: {
              label: Lang.get('fields.si') ,
              className: 'btn-primary'
          },
          cancel: {
              label:  Lang.get('fields.no'),
              className: 'btn-default'
          }
      },
      callback: function (result) {
          if(result){
              _this.props.onRemove();
          }
        }
      });
  }

  render() {

    //define buttons 
    const submitButton = this.props.submitButton !== undefined ? this.props.submitButton : true;
    const cancelButton = this.props.cancelButton !== undefined ? this.props.cancelButton : true;
    const deleteButton = this.props.deleteButton !== undefined ? this.props.deleteButton : true;

    return (
      <div className="custom-modal modal-component" id={this.props.id} style={{ zIndex: this.props.zIndex }}>
        <div className="modal-background"></div>


        <div className={'modal-container ' + this.props.size}>

          <div className="modal-header">

            <i className={this.props.icon}></i>
            <h2>{this.props.title}</h2>

            <div className="modal-buttons">
              <a className="btn btn-default close-button-modal" onClick={this.onModalClose}>
                <i className="fa fa-times"></i>
              </a>
            </div>
          </div>

          <div className="modal-content">
            <div className="container">
              {this.props.children}
            </div>

            <div className="modal-footer">
              {deleteButton &&
                <a href="" className="btn btn-link text-danger" onClick={this.onRemove.bind(this)}>
                  <i className="fas fa-trash-alt"></i> &nbsp; {Lang.get('fields.delete')}
                </a>
              }
              &nbsp;
              {cancelButton &&
                <a href="" className="btn btn-default" onClick={this.onModalClose}>
                  {Lang.get('fields.cancel')}
                </a>
              }
              &nbsp;
                  {submitButton &&
                <a href="" className="btn btn-primary" onClick={this.onSubmit.bind(this)}>
                  {Lang.get('fields.save')}
                </a>
              }
              &nbsp;
                </div>

          </div>
        </div>
      </div>
    );
  }
}

Modal.propTypes = {
  id: PropTypes.string.isRequired,
  size: PropTypes.string.isRequired,
  icon: PropTypes.string,
  title: PropTypes.string.isRequired,
  display: PropTypes.bool.isRequired,
  zIndex: PropTypes.number.isRequired,
  
  submitButton: PropTypes.bool,
  cancelButton: PropTypes.bool,
  deleteButton: PropTypes.bool,

  onSubmit: PropTypes.func,
  onCancel: PropTypes.func,
  onRemove: PropTypes.func

};

