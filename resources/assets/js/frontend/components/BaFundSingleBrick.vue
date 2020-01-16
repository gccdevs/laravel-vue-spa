<template>
	<div class="single-brick is-primary single-brick__outline"
	@click="startModal" :ref="'brick__' + number">
	<!--:style="isActive ? 'animation-delay: ' + number * 100 + 'ms; background-color: ' + color : null"-->
	<!--:class="isActive ? 'single-brick__bold' : 'single-brick__outline'">-->
	<div class="single-brick__content">
		<div class="single-brick__hashtag" :ref="'hashtag__' + number" :class="!isActive ? 'has-text-grey single-brick__hashtag__inactive' : null">
			# <span class="single-brick__number">{{ number }}</span>
		</div>
	</div>
</div>
</template>

<script>
	import { getColorList } from 'frontendUtils/BrickColorList';
	export default {
		data () {
			return {
				colorList: getColorList(),
				color: '',
			}
		},
		props: {
			row: {
				type: Number,
				required: true,
			},
			column: {
				type: Number,
				required: true,
			},
			totalNumber: {
				type: Number,
				required: true
			}
		},
		computed: {
			isActive () {
				return this.number <= this.totalNumber;
			},
			number () {
				return 200 - (10 * this.row + this.column);
			},
        },
        methods: {
        	startModal () {
        		if (this.isActive) {
        			this.$emit('showModal', this.number);
        		}
        	},
        	getColor (row, col) {
        		let rowInndex = (row - 1) < 10 ? (row - 1) : (row - 1) - 10;
        		let colIndex = (col - 1) < 5 ? (col - 1) : (col - 1) - 5;

        		if(this.colorList[rowInndex]) {
        			return this.colorList[rowInndex][colIndex];
        		} else {
        		}
        	}
        },
        mounted () {
        	this.color = this.getColor(20 - parseInt(this.row) , 10 - parseInt(this.column));
        	let self = this;
        	setTimeout(function() {
        		if (self.isActive) {
        			self.$refs['brick__' + self.number].style.backgroundColor = self.color;
        			self.$refs['brick__' + self.number].classList.add('single-brick__bold');
        			self.$refs['hashtag__' + self.number].style.color = 'white';
        		}
        	}, this.number * 50);
        }
    }
</script>

<style lang="scss">
.single-brick {
	position: relative;
	margin-left: 1px;
	margin-right: 1px;
	border-radius: 3px;
	outline: none;
	box-shadow: none;
	text-align: center;
	vertical-align: middle;
	animation-fill-mode: both;
	@media screen and (max-width: 575px) {
		height: 20px;
	}
	@media (min-width: 576px) and (max-width: 991px) {
		height: 28px;
	}
	@media (min-width: 992px) {
		height: 40px;
	}
	&__content {
		position: relative;
		height: 100%;
		width: 100%;
		padding: 0;
		margin: 0;
	}
	&__hashtag {
		&__inactive {
			font-weight: lighter !important;
			@media (min-width: 576px) {
				opacity: 0;
			}
			transition: .3s ease-in;
			&:hover {
				opacity: 1;
			}
		}
		position: absolute;
		width: 100%;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		// color: white;
		@media screen and (max-width: 575px) {
			font-weight: 300;
			font-size: 8px;
		}
		@media (min-width: 576px) and (max-width: 767px) {
			font-weight: normal;
			font-size: 10px;
		}
		@media (min-width: 768px) {
			font-weight: 900;
			font-size: 12px;
		}
	}
	&__amount {
		@media screen and (max-width: 767px) {
			display: none;
		}
	}
	&__verse {
		color: white;
		@media screen and (max-width: 767px) {
			display: none;
		}
	}
	&__bold {
		animation-fill-mode: both;
		animation: showBrick .5s;
		box-shadow: 2px 2px 2px 2px #BEBEBE;
		transition: 0.14s ease-in;
		&:hover {
			box-shadow: 2px 2px 2px 2px darken(#BEBEBE, 15%);
			cursor: pointer;
		}
	}
	&__outline {
		/*background-color: transparent;*/
		border: 1px dashed lighten(rgb(121, 75, 156), 10%);
		opacity: 0.85;
	}
}
@keyframes showBrick {
	0% {
		transform: translateY(-100%);
	}
	50% {
		transform: translateY(-50%);
	}
	100% {
		transform: translateY(0);
	}
}
</style>
