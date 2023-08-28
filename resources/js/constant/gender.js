export const genderOptions = [
    {
        value: 'm',
        label: 'dashboard.male',
    },
    {
        value: 'f',
        label: 'dashboard.female',
    },
    {
        value: 'o',
        label: 'dashboard.other',
    }
];

export function getGenderFromValue(char) {
    const option = genderOptions.find(item => item.value === char);
    return option ? option.label : '';
}
