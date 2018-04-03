<template>
    <article id="NewsArticle" v-if="news">
        <div class="leftCol">
          <div class="newsBlock" v-for="(n, nIndex) in news" :key="'news'+n.id">
            <div class="topic">
              <p v-if="n.type == 'newProfile'"><router-link :to="{ name: 'profile', params: { id: n.authorId }}">{{n.authorSurname}} {{n.authorName}} {{n.authorPatronymic}}</router-link> зареєструвався.</p>
              <p v-else>{{n.topic}}</p>
              <div class="isCommand" title="Поширино лише для проводу куреня" v-if="n.accessRights=='command'"></div>
            </div>
            <div class="description" v-if="n.description != ''">
              <p>{{n.description}}</p>
            </div>
            <div class="questions">
              <div class="question"  v-for="(question, qIndex) in n.questions" :key="'question'+question.id">
                <p>{{question.question}}</p>
                <div class="answers">

                  <router-link :to="{ path: `/profile/${n.authorId}/accept`}" class="answer" v-if="question.type==2">
                    <input type="radio">
                      <div class="answerName" >Так</div>
                      <div class="chart" >
                        <div class="section" v-for="(chart, cIndex) in n.users" :key="'question'+question.id+'chert'+cIndex" :style="{width: 100/n.users.length+'%'}"></div>
                      </div>
                  </router-link>


                  <label class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==0 || question.type==2">
                      <input type="radio" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.myAnswers[0]">
                      <div class="answerName" :for="'answer'+answer.id" :class="{active: question.myAnswers[0]==answer.id}">{{answer.answer}}</div>
                    <div class="chart" >
                      <div class="section" v-for="(chart, cIndex) in n.users" :key="'question'+question.id+'chert'+cIndex" :style="{width: 100/n.users.length+'%'}"></div>
                      <div class="chertLine" :style="{width: 100/n.users.length*answer.voted.length+'%'}"></div>
                    </div>
                  </label>



                  <label class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==1">
                    <input type="checkbox" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.myAnswers">
                    <div class="answerName" :class="{active: question.myAnswers[question.myAnswers.indexOf(answer.id)]}">{{answer.answer}}</div>
                    <div class="chart" >
                      <div class="section" v-for="(chart, cIndex) in n.users" :key="'question'+question.id+'chert'+cIndex" :style="{width: 100/n.users.length+'%'}"></div>
                      <div class="chertLine" :style="{width: 100/n.users.length*answer.voted.length+'%'}"></div>
                    </div>
                  </label>
                  <div class="chartNum" >
                    <div class="num">0</div>
                    <div class="num" v-for="(chart, cnIndex) in n.users" :key="'question'+question.id+'chartNum'+cnIndex" :style="{width: 100/n.users.length+'%'}">{{cnIndex+1}}</div>
                  </div>


                  <div class="toVote" @click="setAnswer(question.myAnswers, question.id, nIndex, qIndex)">Проголосувати</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <section-create class="rightCol"></section-create>
    </article>
</template>

<script>
var CreateNews = require("../Article/components/CreateNews.vue");

var NewsData = {
  news: "",
  dataQuestion: ""
};

export default {
  name: "NewsArticle",
  components: {
    "section-create": CreateNews
  },
  data: function() {
    return NewsData;
  },
  watch: {
    news: function() {
      this.news = this.news;
    }
  },
  created: function() {
    $.ajax({
      url: "../orlyky/server/get/news.php",
      type: "POST",
      dataType: "json",

      success: function(data) {
        NewsData.news = data.news;
        // alert(data.test);
      },

      error: function() {
        alert("error");
      }
    });
  },
  methods: {
    setAnswer: function(answersId, questionId, nIndex, qIndex) {
      if (Array.isArray(answersId)) {
        var answersIdArray = answersId;
      } else {
        var answersIdArray = [answersId];
      }
      $.ajax({
        url: "../orlyky/server/set/answer.php",
        type: "POST",
        dataType: "json",
        data: {
          answerId: JSON.stringify(answersIdArray),
          questionId: questionId
        },
        success: function(data) {
          $.ajax({
            url: "../orlyky/server/get/question.php",
            type: "POST",
            dataType: "json",
            data: {
              id: questionId
            },
            success: function(data) {
              NewsData.news[nIndex].questions[qIndex].answers =
                data.question.answers;
            }
          });
        }
      });
    }
  }
};

// $(window).scroll(function() {
// });
</script>

<style scoped>
#NewsArticle .newsBlock {
  margin-bottom: 3%;
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
}
#NewsArticle .newsBlock > .topic {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  position: relative;
}
#NewsArticle .newsBlock > .topic > p > a {
  color: rgb(17, 174, 17);
}
#NewsArticle .newsBlock > .topic > p > a:hover {
  text-decoration: underline;
}
#NewsArticle .newsBlock > .topic > .isCommand {
  float: right;
  width: 24px;
  height: 32px;
  background-color: green;
  background-image: url("dist/img/lilea.png");
  background-size: cover;
}
#NewsArticle .newsBlock > .topic > p {
  position: absolute;
  bottom: 10px;
  left: 10px;
  font-size: 1.5em;
  font-weight: bold;
}
#NewsArticle .newsBlock > .description > p {
  padding: 1%;
  box-sizing: border-box;
}
#NewsArticle .newsBlock > .questions > .question > p {
  display: block;
  padding: 1%;
  box-sizing: border-box;
}
#NewsArticle .newsBlock > .questions > .question > .answers::after {
  display: block;
  content: "";
  clear: both;
}
#NewsArticle .newsBlock > .questions > .question > .answers > .answer {
  display: block;
  cursor: pointer;
  width: 96%;
  position: relative;
  margin-left: 2%;
  margin-right: 2%;
  box-sizing: border-box;
}

#NewsArticle .newsBlock > .questions > .question > .answers > .answer > input {
  /* display: none; */
  z-index: 2;
  position: absolute;
  top: 8px;
  left: 2px;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .answerName {
  display: block;
  padding: 0.5%;
  box-sizing: border-box;
  color: rgb(19, 41, 130);
  font-size: 1.1em;
  font-weight: bold;
  position: relative;
}
#NewsArticle .newsBlock > .questions > .question > .answers > .answer > .chart {
  /* background: rgb(0, 0, 0); */
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  float: left;
  z-index: 1;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .chart
  > .section {
  float: left;
  height: 100%;
  border-right: 1px solid silver;
  padding: 0.5%;
  box-sizing: border-box;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .chart
  > .section:first-child {
  border-left: 1px solid black;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .chart
  > .chertLine {
  height: calc(100% - 4px);
  margin-top: 2px;
  margin-bottom: 2px;
  background: linear-gradient(rgb(143, 165, 255), rgb(100, 131, 255));
  z-index: 10;
  position: relative;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .answerName {
  /* background: rgb(228, 228, 228); */
  z-index: 2;
  margin-left: 12px;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer:hover
  > .chart {
  background: rgb(228, 228, 228);
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer:hover
  > .chart
  > .chertLine {
  background: linear-gradient(rgb(134, 159, 255), rgb(66, 96, 219));
}

#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .active {
  color: rgb(0, 0, 0);
}
#NewsArticle .newsBlock > .questions > .question > .answers > .chartNum {
  float: left;
  width: 96%;
  margin-left: 2%;
  margin-right: 2%;
  white-space: nowrap;
  position: relative;
  border-top: 1px solid black;
  box-sizing: border-box;
}
#NewsArticle .newsBlock > .questions > .question > .answers > .chartNum > .num {
  display: inline-block;
  /* float: left; */
  box-sizing: border-box;
  text-align: right;
  position: relative;
  left: -8px;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .chartNum
  > .num:first-child {
  left: -4px;
}
#NewsArticle .newsBlock > .questions > .question > .answers > .toVote {
  cursor: pointer;
  padding: 1%;
  float: right;
  background: linear-gradient(rgb(90, 142, 0), rgb(190, 200, 0));
  color: white;
  margin-top: 2%;
}
</style>
