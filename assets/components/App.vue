<!-- Author: Stefan Sander <mail@stefan-sander.online> -->
<template>
    <div id="layout " style="height:100vh;">
        <div v-for="(meta,category) in this.questionsData" :key="category">
          <h2>{{meta.category}}</h2>
          <div class="accordion" role="tablist">
            <div v-for="(dataRow,dataRowIndex) in meta.questions" :key="dataRowIndex" style="width:100%;float:left;">
              <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                  <b-button v-b-toggle="'collapse-'+category+dataRowIndex" class="m-1" >Toggle Collapse</b-button>
                </b-card-header>
                <b-collapse :id="'collapse-'+category+dataRowIndex" visible accordion="my-accordion" role="tabpanel">
                  <b-card-body>
                    <b-card-text>
                      <h3 :ref="'header'+category+'-'+dataRowIndex">
                        {{dataRow.question}}
                      </h3>
                      <div v-for="(answer,answerIndex) in dataRow.answers" :key="answerIndex">
                        <div style="width:100%;float:left;" v-bind:class="{
                          'answer-correct':  true===isCorrect(category,dataRowIndex,answerIndex),
                          'answer-false':  false===isCorrect(category,dataRowIndex,answerIndex),
                        }">
                          <input type="checkbox" :ref="'answer-'+category+'-'+dataRowIndex+'-'+answerIndex" style="float:left;margin-top:5px;" /><span style="float:left;"
                          >
                          {{answer.value}}</span>
                        </div>
                      </div>
                      <div style="width:100%;float:left;padding-bottom:10px;" >
                          <b-button variant="success" style="width:100%;" @click="solve(category,dataRowIndex)" v-bind:class="{
                          'hidden':  true===isSolved(category,dataRowIndex),
                        }">solve</b-button>
                      </div>
                    </b-card-text>
                  </b-card-body>
                </b-collapse>
              </b-card>
            </div>
          </div>
        </div>
    </div>
</template>
<style>
.hidden {
  display:none;
}
.answer-correct {
  background-color:green;
}
.answer-false {
  background-color:red;
}
</style>
<script>
export default {
  name: 'App',
  data: function() {
    return {
        answers:[],
      }
  },
  methods: {
    isSolved(category,dataRowIndex) {
      return this.answers.hasOwnProperty(category)&&this.answers[category].hasOwnProperty(dataRowIndex)?true:false;
    },
    isCorrect(category,dataRowIndex,answerIndex) {
        if (category in this.answers) {
          if (dataRowIndex in this.answers[category]) {
            if (answerIndex in this.answers[category][dataRowIndex]) {
                return this.answers[category][dataRowIndex][answerIndex];
            }
          }
        }
    },
    solve(category,dataRowIndex) {
      for (let answerIndex in this.questionsData[category]['questions'][dataRowIndex]['answers']) {
          let correct = this.questionsData[category]['questions'][dataRowIndex]['answers'][answerIndex].correct == this.$refs['answer-'+category+'-'+dataRowIndex+'-'+answerIndex][0].checked;
          this.answers[category] = this.answers[category]?this.answers[category]:[];
          this.answers[category][dataRowIndex] = this.answers[category][dataRowIndex]?this.answers[category][dataRowIndex]:[];
          this.answers[category][dataRowIndex][answerIndex] = correct;
      }
      this.$forceUpdate();
    },
  },
created: function() {
    this.questionsData = JSON.parse(document.getElementById('_questions').innerHTML);
},
  mounted: function() {
  },
  updated: function() {
  },
}
</script>