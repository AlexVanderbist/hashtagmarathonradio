<template>
    <div>
        <div class="metric-panel__content m-b-0">
            <h2 class="title is-4">Hype Meter</h2>
        </div>
        <div class="gauge-container">
            <svg class="typeRange" height="165" width="330" view-box="0 0 330 165" style="width:100%">

                <g class="scale" stroke="red"></g>

                <path class="outline" d=""/>
                <path class="fill" d=""/>
                <polygon class="needle" points="220,10 300,210 220,250 140,210"/>
            </svg>
            <div class="output">30</div>
        </div>
    </div>
</template>

<script>
    import { tween } from 'shifty';

    export default {
        props: {
            value: {
                type: Number,
                default: 0
            }
        },

        watch: {
            value(newValue, oldValue) {
                tween({
                    from: { n: oldValue },
                    to: { n: newValue },
                    duration: 5000,
                    easing: 'easeInOutQuad',
                    step: state => this.updateInput(state.n)
                });
            }
        },

        mounted() {
            this.svg = this.$el.querySelector(".typeRange");
            this.output = this.$el.querySelector(".output");
            this.outline = this.$el.querySelector(".outline");
            this.fill = this.$el.querySelector(".fill");
            this.center = this.$el.querySelector(".center");
            this.needle = this.$el.querySelector(".needle");
            this.scale = this.$el.querySelector(".scale");

            this.rad = Math.PI / 180;
            this.NS = "http:\/\/www.w3.org/2000/svg";

            this.draw();

            // events
            window.addEventListener("resize", () => this.draw(), false);

        },
        methods: {
            draw() {
                this.calculateSize();

                this.drawBackground();

                this.drawScale();

                this.updateInput(this.value);
            },

            calculateSize() {
                this.W = parseInt(window.getComputedStyle(this.svg, null).getPropertyValue("width"));
                this.H = this.W / 2;
                this.svg.setAttribute("height", this.H);
                this.offset = 40;
                this.cx = ~~(this.W / 2);
                this.cy = this.H - 5;

                this.r1 = this.cx - this.offset;
                this.delta = ~~(this.r1 / 4);

                this.x1 = this.cx + this.r1,
                    this.y1 = this.cy;
                this.r2 = this.r1 - this.delta;

                this.x2 = this.offset,
                    this.y2 = this.cy;
                this.x3 = this.x1 - this.delta,
                    this.y3 = this.cy;
            },

            drawBackground() {
                var d1 = this.getD1(this.cx, this.cy, this.r1, this.offset, this.delta);
                this.outline.setAttributeNS(null, "d", d1);
            },

            drawScale() {
                const sr1 = this.r1 + 5;
                const sr2 = this.r2 - 5;
                const srT = this.r1 + 20;

                this.clearRect(this.scale);

                var n = 0;
                for (var sa = -180; sa <= 0; sa += 18) {
                    const sx1 = this.cx + sr1 * Math.cos(sa * this.rad);
                    const sy1 = this.cy + sr1 * Math.sin(sa * this.rad);
                    const sx2 = this.cx + sr2 * Math.cos(sa * this.rad);
                    const sy2 = this.cy + sr2 * Math.sin(sa * this.rad);
                    const sxT = this.cx + srT * Math.cos(sa * this.rad);
                    const syT = this.cy + srT * Math.sin(sa * this.rad);

                    var scaleLine = document.createElementNS(this.NS, "line");
                    var scaleLineObj = {
                        class: "scale",
                        x1: sx1,
                        y1: sy1,
                        x2: sx2,
                        y2: sy2
                    };
                    this.setSVGAttributes(scaleLine, scaleLineObj);

                    this.scale.appendChild(scaleLine);

                    var scaleText = document.createElementNS(this.NS, "text");
                    var scaleTextObj = {
                        class: "scale",
                        x: sxT,
                        y: syT,
                    };
                    this.setSVGAttributes(scaleText, scaleTextObj);
                    scaleText.textContent = n * 10;
                    this.scale.appendChild(scaleText);

                    n++;
                }
            },

            updateInput(value) {
                this.output.innerHTML = Math.round(value);

                value = value > 100 ? 100 : value;

                var pa = (value * 1.8) - 180;

                var x = this.cx + this.r1 * Math.cos(pa * this.rad);
                var y = this.cy + this.r1 * Math.sin(pa * this.rad);
                var lx = this.cx - x;
                var ly = this.cy - y;

                var a = Math.atan2(ly, lx) / this.rad - 180;

                this.drawNeedle(a);

                // Background
                var d2 = this.getD2(a);
                this.fill.setAttributeNS(null, "d", d2);

            },

            getD1() {
                const x1 = this.cx + this.r1,
                    y1 = this.cy;
                const x2 = this.offset,
                    y2 = this.cy;
                const r2 = this.r1 - this.delta;
                const x3 = x1 - this.delta,
                    y3 = this.cy;
                const d1 =
                    "M " + x1 + ", " + y1 + " A" + this.r1 + "," + this.r1 + " 0 0 0 " + x2 + "," + y2 + " H" + (this.offset + this.delta) + " A" + r2 + "," + r2 + " 0 0 1 " + x3 + "," + y3 + " z";
                return d1;
            },

            getD2(a) {
                a *= this.rad;
                const r2 = this.r1 - this.delta;
                const x4 = this.cx + this.r1 * Math.cos(a);
                const y4 = this.cy + this.r1 * Math.sin(a);
                const x5 = this.cx + r2 * Math.cos(a);
                const y5 = this.cy + r2 * Math.sin(a);
                const d2 =
                    "M " + x4 + ", " + y4 + " A" + this.r1 + "," + this.r1 + " 0 0 0 " + this.x2 + "," + this.y2 + " H" + (this.offset + this.delta) + " A" + r2 + "," + r2 + " 0 0 1 " + x5 + "," + y5 + " z";
                return d2;
            },

            drawNeedle(a) {
                var nx1 = this.cx + 5 * Math.cos((a - 90) * this.rad);
                var ny1 = this.cy + 5 * Math.sin((a - 90) * this.rad);

                var nx2 = this.cx + (this.r1 + 15) * Math.cos(a * this.rad);
                var ny2 = this.cy + (this.r1 + 15) * Math.sin(a * this.rad);

                var nx3 = this.cx + 5 * Math.cos((a + 90) * this.rad);
                var ny3 = this.cy + 5 * Math.sin((a + 90) * this.rad);

                var points = nx1 + "," + ny1 + " " + nx2 + "," + ny2 + " " + nx3 + "," + ny3;
                this.needle.setAttributeNS(null, "points", points);
            },

            clearRect(node) {
                while (node.firstChild) {
                    node.removeChild(node.firstChild);
                }
            },

            setSVGAttributes(elmt, oAtt) {
                for (var prop in oAtt) {
                    elmt.setAttributeNS(null, prop, oAtt[prop]);
                }
            }
        }
    }
</script>