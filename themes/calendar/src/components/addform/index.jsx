import React, { Component, PropTypes } from 'react';
import { StepOne } from './stepone';
import { StepTwo } from './steptwo';
import { StepThree } from './stepthree';
import { StepFour } from './stepfour';

const steps =
  [
      { name: 'Date', component: <StepOne /> },
      { name: 'Details', component: <StepTwo /> },
      { name: 'Location', component: <StepThree /> },
      { name: 'Restrictions', component: <StepFour /> },
  ];

export { steps };
