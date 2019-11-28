/**
 * Created by d.eggermann on 07.11.19.
 */


const labels = [
    'Deutschlandweit',
    '10km',
    '25km',
    '50km',
    '200km',

]

const values = [
    '',//important
    '10000',
    '25000',
    '50000',
    '200000',
]

module.exports = {

    context: {
        placeholder: 'Umkreissuche',
        label: 'Umkreissuche',
        minLen: '0',
        maxLen: '12',
        options: labels.map((label, i) => {
            return {
                label: label,
                value: values[i]
            }
        })
    }
};
