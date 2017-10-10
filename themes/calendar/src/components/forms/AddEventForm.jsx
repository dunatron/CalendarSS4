'use strict';

import React, { Component } from 'react';
import StepZilla from 'react-stepzilla';
import Step1 from './steps/Step1';
import Step2 from './steps/Step2';
import Step3 from './steps/Step3';
import Step4 from './steps/Step4';
import Step5 from './steps/Step5';
import Step6 from './steps/Step6';

export default class Example extends Component {
  constructor(props) {
    super(props);
    this.state = {};

    this.sampleStore = {
      EventTitle: '',
      EventVenue:'',
      LocationText:'',
      LocationLat:'',
      LocationLon:'',
      SpecLocation:'',
      EventDescription:'',
      EventDate:'',
      StartTime:'',
      FinishTime:'',
      IsFree:'',
      BookingWebsite:'',
      TicketWebsite:'',
      TicketPhone:'',
      Restriction:'',
      SpecEntry:'',
      AccessType:'',
      testField: '',
      email: '',
      gender: '',
      savedToCloud: false,
      serverMessage:'',
      DateTimes: [],
    };
  }

  componentDidMount() {}

  componentWillUnmount() {}

  getStore() {
    return this.sampleStore;
  }

  updateStore(update) {
    this.sampleStore = {
      ...this.sampleStore,
      ...update,
    }
    console.log(this.sampleStore)
  }

  render() {
    const steps =
      [
        {name: 'Date', component: <Step1 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />},
        {name: 'Step2', component: <Step2 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />},
        {name: 'Step3', component: <Step3 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />},
        {name: 'step4', component: <Step4 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />},
        {name: 'Review', component: <Step5 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />},
        {name: 'Done', component: <Step6 getStore={() => (this.getStore())} updateStore={(u) => {this.updateStore(u)}} />}
      ]

    return (
      <div className='example'>
        <div className='step-progress'>
          <StepZilla
            steps={steps}
            preventEnterSubmission={true}
            nextTextOnFinalActionStep={"Submit Event"}
            hocValidationAppliedTo={[3]}
          />
        </div>
      </div>
    )
  }
}
