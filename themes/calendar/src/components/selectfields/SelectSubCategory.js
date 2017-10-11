import React from 'react';
import createClass from 'create-react-class';
import PropTypes from 'prop-types';
import Select from 'react-select';
import axios from 'axios';

let SelectSubCategory = createClass({
  displayName: 'SelectSubCategory',
  propTypes: {
    label: PropTypes.string,
  },
  getInitialState () {
    return {
      disabled: false,
      stayOpen: false,
      value: [],
    };
  },
  handleSelectChange (value) {
    console.log('You\'ve selected:', value);
    this.setState({ value });
  },
  testOptions (input, callback) {
    setTimeout(function() {
      callback(null, {
        options: [
          { value: 'one', label: 'One' },
          { value: 'two', label: 'Two' }
        ],
        // CAREFUL! Only set this to true when there are no more options,
        // or more specific queries will not be sent to the server.
        complete: true
      });
    }, 500);
  },
  getOptions (input, callback) {


    let staticOptions = [
      { value: 1, label: 'One' },
      { value: 2, label: 'Two' }
    ];


    axios({
      method: 'post',
      url: '/pagefunction/getSubCategoryOptions',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
      .then(response => {
        let data = response.data;
        console.log(response);

        console.log('THE DATA');
        console.log(data);

        console.log('====Static Options=====');
        console.log(staticOptions);
        console.log('======Dynamic Options =======');
        console.log(data);

        // callback(null, {
        //   options: data,
        //   // options: [
        //   //   { value: 'one', label: 'One' },
        //   //   { value: 'two', label: 'Two' },
        //   //   { value: 'Three', label: 'Three' }
        //   // ],
        //   // CAREFUL! Only set this to true when there are no more options,
        //   // or more specific queries will not be sent to the server.
        //   complete: true
        // });
        // callback(null, {
        //   options: [
        //     { value: 'one', label: 'One' },
        //     { value: 'two', label: 'Two' }
        //   ],
        //   // CAREFUL! Only set this to true when there are no more options,
        //   // or more specific queries will not be sent to the server.
        //   complete: true
        // });
        callback(null, {
          options: data,
          // CAREFUL! Only set this to true when there are no more options,
          // or more specific queries will not be sent to the server.
          complete: true
        });
      })
      .catch(error => {
        console.log('======Caught an error=======');
        console.log(error);

      });
  },
  toggleCheckbox (e) {
    this.setState({
      [e.target.name]: e.target.checked,
    });
  },
  render () {
    const { disabled, stayOpen, value } = this.state;
    return (
      <div className="section">
        <h3 className="section-heading">{this.props.label}</h3>
        <Select.Async
          closeOnSelect={!stayOpen}
          disabled={disabled}
          multi
          onChange={this.handleSelectChange}
          //options={options}
          placeholder="Select your favourite(s)"
          simpleValue
          value={value}
          loadOptions={this.getOptions}
        />
      </div>
    );
  }
});

module.exports = SelectSubCategory;