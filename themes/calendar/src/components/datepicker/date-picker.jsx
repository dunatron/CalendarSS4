import React from 'react';
import DayPicker, { DateUtils } from 'react-day-picker';
//http://react-day-picker.js.org/

import 'react-day-picker/lib/style.css';

export default class DatePicker extends React.Component {
    state = {
        selectedDays: [],
    };
    handleDayClick = (day, { selected }) => {
        const { selectedDays } = this.state;
        if (selected) {
            const selectedIndex = selectedDays.findIndex(selectedDay =>
                DateUtils.isSameDay(selectedDay, day)
            );
            selectedDays.splice(selectedIndex, 1);
        } else {
            selectedDays.push(day);
        }
        this.setState({ selectedDays });
    };
    render() {
        return (
            <div>
                <DayPicker
                    selectedDays={this.state.selectedDays}
                    onDayClick={this.handleDayClick}
                />
            </div>
        );
    }
}