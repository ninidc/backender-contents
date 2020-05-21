import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

export default class ButtonPrimary extends Component {

    constructor(props)
    {
        super(props);
    }

    render() {
        return (
          <a href={this.props.route} className="btn btn-primary" onClick={this.props.onClick}>
            <i className={this.props.icon}></i>
            &nbsp;&nbsp;
            {this.props.label}
          </a>
        );
    }
}

ButtonPrimary.propTypes = {
  label: PropTypes.string.isRequired,
  icon: PropTypes.string,
  route: PropTypes.string,
  onClick: PropTypes.func
};
