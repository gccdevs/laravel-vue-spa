export function getFormFieldType (type) {
    if (type === 'Input' || type === 'input' || type === 'INPUT' || type ==='CUSTOM_INPUT') {
        return 'input';
    }
    if (type === 'Number' || type === 'number' || type === 'NUMBER' || type ==='CUSTOM_NUMBER') {
        return 'number';
    }
    if (type === 'Long Text' || type === 'long text' || type === 'LONG TEXT' || type ==='CUSTOM_TEXT') {
        return 'textarea';
    }
    if (type === 'Datepicker' || type === 'datepicker' || type === 'DATEPICKER' || type ==='CUSTOM_DATEPICKER') {
        return 'datepicker';
    }
    if (type === 'Timepicker' || type === 'timepicker' || type === 'TIMEPICKER' || type ==='CUSTOM_TIMEPICKER') {
        return 'timepicker';
    }
    if (type === 'Dropdown' || type === 'dropdown' || type === 'DROPDOWN' || type ==='CUSTOM_DROPDOWN') {
        return 'dropdown';
    }
    if (type === 'Radio' || type === 'radio' || type === 'RADIO' || type ==='CUSTOM_RADIO') {
        return 'radio';
    }
    if (type === 'Checkbox' || type === 'checkbox' || type === 'CHECKBOX' || type ==='CUSTOM_CHECKBOX') {
        return 'checkbox';
    }
    if (type === 'Email' || type === 'email' || type === 'EMAIL' || type ==='CUSTOM_EMAIL') {
        return 'email';
    }
    return 'input'
}
