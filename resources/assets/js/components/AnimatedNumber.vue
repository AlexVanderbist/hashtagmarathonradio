<template>
    <span>
        {{ formattedNumber }}
    </span>
</template>

<script>
    import { tween } from 'shifty';
    import numeral from 'numeral';

    numeral.register('locale', 'nl', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        ordinal : function (number) {
            return number === 1 ? 'er' : 'ème';
        },
        currency: {
            symbol: '€'
        }
    });
    numeral.locale('nl');

    export default {
        props: {
            number: {
                type: [String, Number],
                default: 0
            },
            format: {
                type: String,
                default: '0,0'
            }
        },

        data() {
            return {
                displayNumber: 0,
            }
        },

        computed: {
            formattedNumber() {
                return numeral(this.displayNumber).format(this.format || '0,0');
            }
        },

        ready() {
            this.displayNumber = this.number ? this.number : 0;
        },

        watch:{
            number() {
                if (this.number == this.displayNumber) {
                    return;
                }

                tween({
                    from: { n: this.displayNumber },
                    to: { n: this.number },
                    duration: 5000,
                    easing: 'easeInOutQuad',
                    step: state => this.displayNumber = state.n
                });
            }
        }
    }
</script>