// import React from 'react';
'use strict';
import React from 'react';
import Multistep from '../addform/react-multistep/src/index';
import { steps } from '../addform/index';
export default class AddEventForm extends React.Component {

  render() {
    return (
      <div className="container">
        <div>
          <Multistep initialStep={1} steps={steps} />
        </div>
        <div className="container app-footer">
          <h6>use arrow keys or progress bar to navigate form.</h6>
        </div>
      </div>
    );
  }
}
