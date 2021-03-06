/* eslint no-console:0 */
// https://www.npmjs.com/package/rc-time-picker

import 'rc-time-picker/assets/index.css';

import React from 'react';

import moment from 'moment';

import TimePicker from 'rc-time-picker';

const format = 'h:mm a';

const now = moment().hour(0).minute(0);

function onChange(value) {
  console.log(value && value.format(format));
}


export default class HappTimePicker extends React.Component {

    render() {
        return (
            <div>
                <TimePicker
                    showSecond={false}
                    defaultValue={now}
                    className="xxx"
                    onChange={onChange}
                    format={format}
                    use12Hours
                />
            </div>
        );
    }
}
