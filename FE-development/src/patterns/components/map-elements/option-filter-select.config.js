/**
 * Created by d.eggermann on 07.11.19.
 */
const labels = [
    'Option 1',
    'Option 2',
    'Option 3'
];

const values = [
    'Option 1',
    'Option 2',
    'Option 3'
];

module.exports = {

    context: {
        label: 'Filter name',
        options: labels.map((label, i) => {
            return {
                label: label,
                value: values[i]
            }
        })
    }
};
