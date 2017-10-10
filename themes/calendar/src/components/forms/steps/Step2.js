'use strict';

import React, { Component } from 'react';
import PropTypes from 'prop-types';
import validation from 'react-validation-mixin';
import strategy from 'joi-validation-strategy';
import Joi from 'joi';
import Dropdown from 'react-dropdown';
import Select from 'react-select';
import 'react-select/dist/react-select.css';
import SelectSubCategory from '../../selectfields/SelectSubCategory';

class Step2 extends Component {
  constructor(props) {
    super(props);

    this.state = {

      EventTitle: props.getStore().EventTitle,
      EventDescription: props.getStore().EventDescription,
      MainCategory: props.getStore().MainCategory
    };

    this.validatorTypes = {
      EventTitle: Joi.string().required(),
      EventDescription: Joi.string().required(),
      MainCategory: Joi.string().required()
    };

    this.getValidatorData = this.getValidatorData.bind(this);
    this.renderHelpText = this.renderHelpText.bind(this);
    this.isValidated = this.isValidated.bind(this);
  }

  isValidated() {
    return new Promise((resolve, reject) => {
      this.props.validate((error) => {
        if (error) {
          reject(); // form contains errors
          return;
        }

        if (this.props.getStore().EventDescription != this.getValidatorData().EventDescription) { // only update store of something changed
          this.props.updateStore({
            ...this.getValidatorData(),
            savedToCloud: false // use this to notify step4 that some changes took place and prompt the user to save again
          });  // Update store here (this is just an example, in reality you will do it via redux or flux)
        }

        resolve(); // form is valid, fire action
      });
    });
  }

  getValidatorData() {
    return {
      EventTitle: this.refs.EventTitle.value,
      EventDescription: this.refs.EventDescription.value,
      MainCategory: this.refs.EventDescription.value,
    };
  }

  onChange(e) {
    let newState = {};
    newState[e.target.name] = e.target.value;
    this.setState(newState);
  }

  renderHelpText(message, id) {
    return (<div className="val-err-tooltip" key={id}><span>{message}</span></div>);
  }

  render() {
    // explicit class assigning based on validation
    let notValidClasses = {};
    notValidClasses.EventDescriptionCls = this.props.isValid('EventDescription') ?
      'no-error col-md-8' : 'has-error col-md-8';

    /*
  * assuming the API returns something like this:
  *   const json = [
  *      { value: 'one', label: 'One' },
  *      { value: 'two', label: 'Two' }
  *   ]
  */
    const getMainCategoryOptions = (input) => {
      return fetch(`/pagefunction/getMainCategoryOptions`)
        .then((response) => {
          return response.json();
        }).then((json) => {
          return { options: json };
        });
    };

    let getOptions = function(input, callback) {
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
    };

    function handleTagChange(val) {
      console.log("Selected: " + JSON.stringify(val));
    }

    return (
      <div className="step step4">
        <div className="row">
          <form id="Form" className="form-horizontal">
            <div className="form-group">
              <label className="control-label col-md-12 ">
                <h1>Step 4: Form Validation using "react-validation-mixin" Example</h1>
              </label>
            </div>


            <div className="form-group col-md-12 content form-block-holder">
              <label className="control-label col-md-4">
                EventTitle
              </label>
              <div className={notValidClasses.EventDescriptionCls}>
                <input
                  ref="EventTitle"
                  name="EventTitle"
                  autoComplete="off"
                  type="text"
                  className="form-control"
                  placeholder="Event Title"
                  required
                  defaultValue={this.state.EventTitle}
                  onBlur={this.props.handleValidation('EventTitle')}
                  onChange={this.onChange.bind(this)}
                />

                {this.props.getValidationMessages('EventTitle').map(this.renderHelpText)}
              </div>
            </div>

            <div className="form-group col-md-12 content form-block-holder">
              <label className="control-label col-md-4">
                Event Description
              </label>
              <div className={notValidClasses.EventDescriptionCls}>
                <input
                  ref="EventDescription"
                  name="EventDescription"
                  autoComplete="off"
                  type="Text"
                  className="form-control"
                  placeholder="Event Description"
                  required
                  defaultValue={this.state.EventDescription}
                  onBlur={this.props.handleValidation('EventDescription')}
                  onChange={this.onChange.bind(this)}
                />

                {this.props.getValidationMessages('EventDescription').map(this.renderHelpText)}
              </div>
            </div>

            <div className="form-group col-md-12 content form-block-holder">
              <label className="control-label col-md-4">
                Select A Tag
              </label>
              <div className={notValidClasses.EventDescriptionCls}>
                <Select.Async
                  name="form-field-name"
                  loadOptions={getOptions}
                  value="one"
                  onChange={handleTagChange}
                />
                {this.props.getValidationMessages('EventDescription').map(this.renderHelpText)}
              </div>
            </div>

            <div className="form-group col-md-12 content form-block-holder">
              <label className="control-label col-md-4">
                Select A Tag
              </label>
              <div className={notValidClasses.EventDescriptionCls}>
                <SelectSubCategory />
                {this.props.getValidationMessages('EventDescription').map(this.renderHelpText)}
              </div>
            </div>



            <div className="form-group hoc-alert col-md-12 form-block-holder">
              <label className="col-md-12 control-label">
                <h4>As shown in this example, you can also use <a href="https://github.com/jurassix/react-validation-mixin" target="_blank">react-validation-mixin</a> to handle your validations as well! (as of v4.3.2)!</h4>
              </label>
              <br />
              <div className="green">... so StepZilla step Components can either use basic JS validation or Higer Order Component (HOC) based validation with react-validation-mixin.</div>
            </div>
          </form>
        </div>
      </div>
    );
  }
}

Step2.propTypes = {
  errors: PropTypes.object,
  validate: PropTypes.func,
  isValid: PropTypes.func,
  handleValidation: PropTypes.func,
  getValidationMessages: PropTypes.func,
  clearValidations: PropTypes.func,
  getStore: PropTypes.func,
  updateStore: PropTypes.func
};

export default validation(strategy)(Step2);
