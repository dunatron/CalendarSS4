'use strict';
import React, { Component, PropTypes } from 'react';
import DatePicker from '../datepicker/date-picker';
import HappTimePicker from '../timepicker/time-picker';

const store = {
  firstName: '',
  lastName: '',
};

const StepOne = React.createClass({
  getInitialState() {
    return store;
  },

  handleFirstNameChanged(event) {
    store.firstName = event.target.value;
    this.setState(store);
  },

  handleLastNameChanged(event) {
    store.lastName = event.target.value;
    this.setState(store);
  },

  render() {
    return (
        <div>
            <div className="form-group">
                <DatePicker />
                <HappTimePicker />
                <label htmlFor="FirstName">First Name</label>
                <input type="text" className="form-control" id="FirstName" aria-describedby="emailHelp" placeholder="FirstName" onChange={this.handleFirstNameChanged}
                  value={this.state.firstName}
                  autoFocus
    />
                    <small id="emailHelp" className="form-text text-muted">
                        We'll never share your email with anyone else.
                    </small>
            </div>
        </div>
    );},
});

export { StepOne };
