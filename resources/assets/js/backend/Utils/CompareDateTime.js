import moment from 'moment';

export function compareDateError (start_date, expired_date) {
    if (!start_date || !expired_date || start_date === '' || expired_date === '') {
        console.log('dates are null');
        return true;
    }

    if (moment(expired_date, 'YYYY-MM-DD').isBefore(moment(start_date, 'YYYY-MM-DD'))) {
        return true;
    }
    return false;
}

export function compareDateTimeError (start_date, start_time, expired_date, expired_time) {
    if (!start_date || !start_time || !expired_date || !expired_time ||
        start_date === '' || start_time === '' || expired_date === '' || expired_time === '' ) {
        console.log('dates and are null');
        return true;
    }

    if (moment(expired_date, 'YYYY-MM-DD').isBefore(moment(start_date, 'YYYY-MM-DD'))) {
        return true;
    } else if (moment(expired_date, 'YYYY-MM-DD').isSame(moment(start_date, 'YYYY-MM-DD'))) {
        if (moment(expired_time, 'HH:mm:s').isSameOrBefore(moment(start_time, 'HH:mm:s'))) {
            return true;
        }
    }
    return false;
}