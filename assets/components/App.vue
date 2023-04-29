<!-- Author: Stefan Sander <mail@stefan-sander.online> -->
<template>
    <div id="layout " style="height:100vh;">
        <div v-for="(meta,category) in this.questionsData" :key="category">
          <h2>{{meta.category}}</h2>
          <div v-for="(dataRow,dataRowIndex) in meta.questions" :key="dataRowIndex" style="width:100%;float:left;padding-top:20px;">
            <h3>
              {{dataRow.question}}
            </h3>
            <div v-for="(answer,answerIndex) in dataRow.answers" :key="answerIndex">
              <div style="width:100%;float:left;">
                <input type="checkbox"  style="float:left;" /><span style="float:left;">{{answer.value}}</span>
              </div>
            </div>
              <div style="width:100%;float:left;padding-top:10px;">
                <input type="button" value="solve" />
              </div>
          </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'App',
  data: function() {
    return {
        active:null,
      }
  },
  methods: {
      currentRoute(route) {
       return route==this.$router.currentRoute.name
      },
      go(page) {
        this.$router.push({ name: page})
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