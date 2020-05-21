import React, {Component} from 'react'
import {connect} from 'react-redux';

import {initState} from './actions/';

import ContentContainer from './Content/ContentContainer';
import PageContainer from './Page/PageContainer';

class ContentForm extends Component {

    constructor(props) {
      super(props);

      var data = {
          typology : props.typology ? JSON.parse(atob(props.typology)) : '',
          content : props.content ? JSON.parse(atob(props.content)) : '',
          fields : props.fields ? JSON.parse(atob(props.fields)) : '',
          tags : props.tags ? JSON.parse(atob(props.tags)) : '',
          page : props.page ? JSON.parse(atob(props.page)) : '',
          pages : props.pages ? JSON.parse(atob(props.pages)) : '',
          settings : props.settings ? JSON.parse(atob(props.settings)) : '',
          categories : props.categories ? JSON.parse(atob(props.categories)) : '',
          saved : props.content || props.page ? true : false
      };

      //init state
      this.props.initState(data);

    }

    render() {

      const page = this.props.typology ? false : true;

      return (
				<div>
          {!page &&
            <ContentContainer />
          }
          {page &&
            <PageContainer />
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
        initState: (payload) => {
            return dispatch(initState(payload));
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ContentForm);
