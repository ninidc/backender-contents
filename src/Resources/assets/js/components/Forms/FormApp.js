import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Provider } from "react-redux";
import { createStore } from "redux";
import rootReducer from "./reducers/index";
import { connect } from 'react-redux'

import FormBuilder from './FormBuilder';

import configureStore from './configureStore'

let store = configureStore();

if (document.getElementById('form-builder')) {
    var element = document.getElementById('form-builder');
    var form = element.getAttribute('form');
    var layout = element.getAttribute('layout');
    var fields = element.getAttribute('fields');

    ReactDOM.render(
      <Provider store={store}>
        <FormBuilder
          form={form}
          layout={layout}
          fields={fields}
        />
      </Provider>
    , element);
}
