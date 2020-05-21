import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './../actions/';

import Box from './Box';
import Row from './Row';
import Field from './Field';
import Br from './Br';
import Hr from './Hr';

class Col extends Component {

  constructor(props) {
    super(props);
  }

  renderCol() {
      const {children} = this.props.data;

      if(children === undefined || children == null)
        return null;

      return children.map((item,index) => {
        if(item.type == "box"){
          return (
            <Box
              index={index}
              key={index}
              data={item}
              pathToIndex={this.getPathToIndex(index)}
              childrenLength={item.children.length}
            />
          )
        }
        else if(item.type == "row"){
          return (
            <Row
              index={index}
              key={index}
              data={item}
              pathToIndex={this.getPathToIndex(index)}
              childrenLength={item.children.length}
            />
          )
        }
        else if(item.type == "field"){
          return (
            <Field
              index={index}
              key={index}
              data={item}
              pathToIndex={this.getPathToIndex(index)}
            />
          )
        }
        else if(item.type == "br") {
          return (<Br
            key={index}
          />);
        }
        else if(item.type == "hr") {
          return (<Hr
            key={index}
          />);
        }


      });
  }

  getPathToIndex(index) {
    const pathToIndex = this.props.pathToIndex.slice(0);
    pathToIndex.push(parseInt(index));
    return pathToIndex;
  }

  render() {

    return (
      <div className={"col "+this.props.data.class}>
        {this.renderCol()}
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
        /*
        changeField: (field) => {
            return dispatch(changeField(field));
        }
        */
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Col);
