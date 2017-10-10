import React from 'react';
import createClass from 'create-react-class';
import PropTypes from 'prop-types';
import Select from 'react-select';
import axios from 'axios';

const FLAVOURS = [
  { label: 'Chocolate', value: 'chocolate' },
  { label: 'Vanilla', value: 'vanilla' },
  { label: 'Strawberry', value: 'strawberry' },
  { label: 'Caramel', value: 'caramel' },
  { label: 'Cookies and Cream', value: 'cookiescream' },
  { label: 'Peppermint', value: 'peppermint' },
];

const WHY_WOULD_YOU = [
  { label: 'Chocolate (are you crazy?)', value: 'chocolate', disabled: true },
].concat(FLAVOURS.slice(1));

var SelectSubCategory = createClass({
  displayName: 'SelectSubCategory',
  propTypes: {
    label: PropTypes.string,
  },
  getInitialState () {
    return {
      disabled: false,
      crazy: false,
      stayOpen: false,
      value: [],
    };
  },
  handleSelectChange (value) {
    console.log('You\'ve selected:', value);
    this.setState({ value });
  },
  getOptions (input, callback) {
    // setTimeout(function() {
    //   callback(null, {
    //     options: [
    //       { value: 'one', label: 'One' },
    //       { value: 'two', label: 'Two' }
    //     ],
    //     // CAREFUL! Only set this to true when there are no more options,
    //     // or more specific queries will not be sent to the server.
    //     complete: true
    //   });
    // }, 500);
    axios({
      method: 'post',
      url: '/pagefunction/getMainCategoryOptions',
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

        callback(null, {
          options: data,
          // options: [
          //   { value: 'one', label: 'One' },
          //   { value: 'two', label: 'Two' },
          //   { value: 'Three', label: 'Three' }
          // ],
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
    const { crazy, disabled, stayOpen, value } = this.state;
    const options = crazy ? WHY_WOULD_YOU : FLAVOURS;
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

        <div className="checkbox-list">
          <label className="checkbox">
            <input type="checkbox" className="checkbox-control" name="disabled" checked={disabled} onChange={this.toggleCheckbox} />
            <span className="checkbox-label">Disable the control</span>
          </label>
          <label className="checkbox">
            <input type="checkbox" className="checkbox-control" name="crazy" checked={crazy} onChange={this.toggleCheckbox} />
            <span className="checkbox-label">I don't like Chocolate (disabled the option)</span>
          </label>
          <label className="checkbox">
            <input type="checkbox" className="checkbox-control" name="stayOpen" checked={stayOpen} onChange={this.toggleCheckbox}/>
            <span className="checkbox-label">Stay open when an Option is selected</span>
          </label>
        </div>
      </div>
    );
  }
});

module.exports = SelectSubCategory;