'use strict';

import React, { Component } from 'react';
import Promise from 'promise';
import axios from 'axios';

export default class Step5 extends Component {
  constructor(props) {
    super(props);

    this.state = {
      saving: false
    };

    this.isValidated = this.isValidated.bind(this);
  }

  componentDidMount() {}

  componentWillUnmount() {}

  // This review screen had the 'Save' button, on clicking this is called
  isValidated() {
    // typically this method needs to return true or false (to indicate if the local forms are validated, so StepZilla can move to the next step),
    // but in this example we simulate an ajax request which is async. In the case of async validation or server saving etc. return a Promise and StepZilla will wait
    // ... for the resolve() to work out if we can move to the next step
    // So here are the rules:
    // ~~~~~~~~~~~~~~~~~~~~~~~~
    // SYNC action (e.g. local JS form validation).. if you return:
    // true/undefined: validation has passed. Move to next step.
    // false: validation failed. Stay on current step
    // ~~~~~~~~~~~~~~~~~~~~~~~~
    // ASYNC return (server side validation or saving data to server etc).. you need to return a Promise which can resolve like so:
    // resolve(): validation/save has passed. Move to next step.
    // reject(): validation/save failed. Stay on current step

    this.setState({
      saving: true
    });

    /**
    this.props.updateStore({savedToCloud: true});

    axios({
      method: 'post',
      url: '/pagefunction/storeEvent',
      data: this.props.getStore(),
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
      .then(response => {
        let data = response.data;
        let status = response.status;
        let statusText = response.statusText;
        let headers = response.headers;
        let config = response.config;


        console.log('=====The State====');
        console.log(this.state);
        console.log('======The Props=====');
        console.log(this.props.getStore());
        console.log('=====The Response=====')


        if(response.data.Success === true)
        {
          console.log('your onto something here');
          console.log('Server Response: ' + data.Success);
        }

        // something has gone wrong on the server

        // something has gone wrong on the client end

        // 200: every thing has gone well

        this.props.updateStore({savedToCloud: true});

        console.log('=======.then headers======');
        console.log('====data====');
        console.log(data);
        console.log('====status====');
        console.log(status);
        console.log('====statusText====');
        console.log(statusText);
        console.log('====headers====');
        console.log(headers);
        console.log('====config====');
        console.log(config);

      })
      .catch(error => {
        console.log('======Caught an error=======');
        console.log(error);
        console.log(error.response)
        console.log(this.state);
        this.props.updateStore({savedToCloud: false});

      });
     **/
    let PROPS = this.props;

    return new Promise(function (resolve, reject) {
      axios({
        method: 'post',
        url: '/pagefunction/storeEvent',
        data: PROPS.getStore(),
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'X-Requested-With': 'XMLHttpRequest',
        }
      })
        .then(response => {

          let data = response.data;
          let status = response.status;
          let statusText = response.statusText;
          let headers = response.headers;
          let config = response.config;

          console.log(response);
          PROPS.updateStore({savedToCloud: true});
          PROPS.updateStore({serverMessage: data.EmailTo});
          console.log('++++++UPDATED++++++++');
          console.log(PROPS.getStore());
          console.log('=======.then headers======');
          console.log('====data====');
          console.log(data);
          // data.ServerMessage
          // data.Success
          console.log('====status====');
          console.log(status);
          console.log('====statusText====');
          console.log(statusText);
          console.log('====headers====');
          console.log(headers);
          console.log('====config====');
          console.log(config);
          resolve();
        })
        .catch(error => {
          console.log('======Caught an error=======');
          console.log(error);
          console.log(error.response)
          PROPS.updateStore({savedToCloud: false});
          reject();
        });
    });

  }

  jumpToStep(toStep) {
    // We can explicitly move to a step (we -1 as its a zero based index)
    this.props.jumpToStep(toStep-1); // The StepZilla library injects this jumpToStep utility into each component
  }

  render() {
    const savingCls = this.state.saving ? 'saving col-md-12 show' : 'saving col-md-12 hide';

    return (
      <div className="step step5 review">
        <div className="row">
          <form id="Form" className="form-horizontal">
            <div className="form-group">
              <label className="col-md-12 control-label">
                <h1>Step 4: Review your Details and 'Save'</h1>
              </label>
            </div>
            <div className="form-group">
              <div className="col-md-12 control-label">
                <div className="col-md-12 txt">
                  <div className="col-md-4">
                    Gender
                  </div>
                  <div className="col-md-4">
                    {this.props.getStore().gender}
                  </div>
                </div>
                <div className="col-md-12 txt">
                  <div className="col-md-4">
                    Email
                  </div>
                  <div className="col-md-4">
                    {this.props.getStore().email}
                  </div>
                </div>
                <div className="col-md-12 txt">
                  <div className="col-md-4">
                    Emergency Email
                  </div>
                  <div className="col-md-4">
                    {this.props.getStore().emailEmergency}
                  </div>
                </div>
                <div className="col-md-12 eg-jump-lnk">
                  <a href="#" onClick={() => this.jumpToStep(1)}>e.g. showing how we use the jumpToStep method helper method to jump back to step 1</a>
                </div>
                <h2 className={savingCls}>Saving to Cloud, pls wait (by the way, we are using a Promise to do this :)...</h2>
              </div>
            </div>
          </form>
        </div>
      </div>
    );
  }
}
