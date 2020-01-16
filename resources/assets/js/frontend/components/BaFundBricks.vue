<template>
	<div class="fund-bricks">
        <div class="fund-bricks__text text-container">
            {{ $i18n.t('fund.brickText1') }}
            <br><br>
            {{ $i18n.t('fund.brickText2') }}
        </div>
		<div class="fund-bricks__inner" ref="fundB" v-if="isChinese">
			<div class="fund-bricks__row columns is-gapless is-mobile" :class="row % 2 == 0 ? 'fund-bricks__row--odd' : 'fund-bricks__row--even'" v-for="bricksRow, row in totalBricks" v-if="canShowBricks">
				<div class="fund-bricks__column column" v-for="brick, column in bricksInOneRow">
					<ba-fund-single-brick
						:row="row"
						:column="column"
                        :totalNumber="totalNumber"
						@showModal="showVerseModal">
					</ba-fund-single-brick>
				</div>
			</div>
		</div>
        <b-modal :active.sync="showVerse">
        	<div class="show-verse__wrap">
	        	<div class="show-verse">
	        		{{ verse ? verse : backupVerse }}
	        	</div>
        	</div>
        </b-modal>
	</div>
</template>

<script>
    import { getVerseList } from "../Utils/200-verse";
    export default {
		data () {
			return {
				isChinese: false,
				firstScroll: true,
				showVerse: false,
                totalNumber: 0,
                verse: '',
                verseList: getVerseList(),
				totalBricks: 20,
				canShowBricks: false,
				bricksInOneRow: 10,
				backupVerse:'你們是世上的光。城造在山上是不能隱藏的。人點燈，不放在斗底下，是放在燈臺上，就照亮一家的人。你們的光也當這樣照在人前，叫他們看見你們的好行為，便將榮耀歸給你們在天上的父 - 馬太福音 5:14-16',
			}
		},
		methods: {
			showVerseModal (number) {
				this.showVerse = true;
				this.verse = this.verseList[number] ? this.verseList[number] : this.backupVerse;
			},
			handleScroll () {
				let elem = this.$refs.fundB;
				if (this.firstScroll && elem) {
				    if (window.scrollY >= elem.offsetTop / 2) {
				    	this.canShowBricks = true;
				    	this.firstScroll = false;
				    } else {
				    	this.canShowBricks = false;
				    }
				}
			}
		},
        mounted () {
			let self = this;
			if (this.$route.query.lang === 'en') {
                this.isChinese = false;
            } else {
                this.isChinese = true;
            }
            axios.get('get-donation-number', {}, {}).then(function (response) {
                if (response.data.totalNumber > 0) {
                    self.totalNumber = parseInt(response.data.totalNumber);
                    self.$nextTick(function() {
                    	let elem = self.$refs.fundB;
                    	if (elem && window.scrollY >= elem.offsetTop / 2 ) {
                    		self.canShowBricks = true;
					    	self.firstScroll = false;
                    	} else {
							window.addEventListener('scroll', self.handleScroll);
                    	}
					})
                }
            })
        }
	}
</script>

<style lang="scss">
.fund-bricks {
	&__inner {
		min-height: 400px;
		max-width: 1000px;
		margin: 0 auto;
	}
	background-color: lighten(#BEBEBE, 20%);
	padding-top: 60px;
	padding-bottom: 60px;
	.columns {
		margin-bottom: 2px !important;
	}
	&__text {
	    margin: 0 auto;
	    padding-bottom: 30px;
	    font-size: 18px;
	    font-weight: normal;
		    @media screen and (max-width: 575px) {
	    	padding-left: 15px;
		    padding-right: 15px;
		}
	}
	&__row {
		max-width: 100%;
		&--even {
			padding-right: 3px;
			padding-left: 3%;
		}
		&--odd {
			padding-left: 3px;
			padding-right: 3%;
		}
	}

	&__column {
	}
}
.show-verse {
	&__wrap {

	}
	text-align: center;
	color: white;
}
</style>
