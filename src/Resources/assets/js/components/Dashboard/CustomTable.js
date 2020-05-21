import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class CustomTable extends Component 
{
    constructor(props)
    {
        super(props);

        this.state = {
            rows : [],
            columns : [],
        };

    }

    componentDidMount() 
    {
        var self = this;
        axios.get(this.props.route)
            .then(response => {
                if(
                    response.status == 200 
                    && response.data !== undefined 
                ){
                    self.setState({
                        rows : response.data.rows,
                        columns : response.data.columns,
                    });
                }
            }).catch(function (error) {
                console.log(error);
            });
    }

    onItemClick(item,e) 
    {
      e.preventDefault();
      window.location.href = routes['showContent'].replace(':id',item.id);
    }

    renderRows() 
    {
      var result = [];
      const {rows, columns} = this.state;
      var counter = 0;
      const max = this.props.max !== undefined ? parseInt(this.props.max) : 25;

      return rows.map(function(row, key) {
        return (
          <tr>
            {Object.keys(columns).map(function(column) {
              return (
                <td>
                  <span dangerouslySetInnerHTML={{ __html: row[column] }}></span>
                </td>
              )
            })}
          </tr>
        )
      });
    
      return result;
    }

    render() 
    {
        var self = this;
        var columns = Object.keys(this.state.columns).map(function(name, key) {
          return self.state.columns[name];
        });

        return (
          <div className="dashboard-table">
              <div className="dashboard-table-header">
                <h3>{this.props.title}</h3>
                <table>
                  <thead>
                    <tr>
                    {columns.map((column, key) =>
                        <th key={key}>{column}</th>
                    )}
                    </tr>
                  </thead>
                </table>
              </div>

              <div className="dashboard-table-body">
                <table>
                  <tbody>
                    { this.renderRows() }
                  </tbody>
                </table>
              </div>

          </div>
        );
    }
}

if (document.getElementById('custom-table')) 
{
    document.querySelectorAll('[id=custom-table]').forEach( element => {

      var title = element.getAttribute('title');
      var route = element.getAttribute('route');
      var columns = element.getAttribute('columns');
      var max = element.getAttribute('max');

      ReactDOM.render(<CustomTable
          title = {title}
          columns = {columns}
          route = {route}
          max = {max}
        />, element);
    });
}
