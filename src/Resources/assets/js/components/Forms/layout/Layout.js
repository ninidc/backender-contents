import React, {Component} from 'react';
import { render } from 'react-dom';
import Select from 'react-select';
import {connect} from 'react-redux';

import {
  //changeField
} from './../actions/';

import Box from './Box';
import Row from './Row';
import Br from './Br';
import Hr from './Hr';

class Layout extends Component {

  constructor(props) {
    super(props);
  }

  renderLayout() {

    const {layout} = this.props;

    if(layout == null)
      return;

    return (
        layout.map((item,index) => {
          if(item.type == "box") {
            return (
              <Box
                index={index}
                key={index}
                data={item}
                pathToIndex={[parseInt(index)]}
                childrenLength={layout.length}
              />
            );
          }
          else if(item.type == "row") {
            return (<Row
              index={index}
              key={index}
              data={item}
              pathToIndex={[parseInt(index)]}
              childrenLength={layout.length}
            />);
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

        })
    );
  }

  render() {

    var self = this;

    return (
      <div className="layout form-fields">
        {this.renderLayout()}
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

export default connect(mapStateToProps, mapDispatchToProps)(Layout);
