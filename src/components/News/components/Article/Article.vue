<template>
    <article id="NewsArticle" v-if="news">
        <div class="leftCol">
          <div class="newsBlock" v-for="(n, nIndex) in news" :key="'news'+n.id">
            <div class="topic">
              <p v-if="n.type == 'newProfile'"><router-link :to="{ name: 'profile', params: { id: n.authorId }}">{{n.authorSurname}} {{n.authorName}} {{n.authorPatronymic}}</router-link> зареєструвався.</p>
              <p v-else>{{n.topic}}</p>
              <div class="isCommand" title="Бачить лише провід куреня" v-if="n.accessRights=='command'"></div>
            </div>
            <div class="description" v-if="n.description != ''">
              <p>{{n.description}}</p>
            </div>
            <div class="questions">
              <div class="question"  v-for="(question, qIndex) in n.questions" :key="'question'+question.id">
                <p>{{question.question}}</p>
                <div class="answers">
                  <!-- <div class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==0">
                      <input @click="setAnswer(answer.id, question.id)" type="radio" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.usersAnswers[0]">
                      <label :for="'answer'+answer.id"><p :class="{active: question.usersAnswers[0]==answer.id}">{{answer.answer}}</p></label>
                  </div> -->



                  <label class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==1">
                    <input type="checkbox" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.myAnswers">
                    <div class="answerName" :class="{active: question.myAnswers[question.myAnswers.indexOf(answer.id)]}">{{answer.answer}}</div>
                    <div class="chart" :style="{width: 100/n.users.length*answer.voted.length+'%'}"></div>
                  </label>




                  <div class="answer">
                      <router-link class="answerName" :to="{ path: `/profile/${n.authorId}/accept`}" v-if="question.type==2">Так</router-link>
                  </div>
                  <label class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==2">
                      <input type="radio" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.myAnswers[0]">
                      <div class="answerName" :for="'answer'+answer.id" :class="{active: question.myAnswers[0]==answer.id}">{{answer.answer}}</div>
                      <div class="chart" :style="{width: 100/n.users.length*answer.voted.length+'%'}"></div>
                  </label>
                  <div class="answer">
                    <div class="answerName">Не голосували</div>
                    <div class="chart" :style="{width: 100/n.users.length+'%'}"></div>
                  </div>
                  <div @click="setAnswer(question.myAnswers, question.id, nIndex, qIndex)">Проголосувати</div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </article>
</template>

<script>
var NewsData = {
  news: "",
  dataQuestion: ""
};

export default {
  name: "NewsArticle",
  data: function() {
    return NewsData;
  },
  watch: {
    news: function() {
      this.news = this.news;
    }
  },
  created: function() {
    this.news = "";
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
#NewsArticle {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  height: 100%;
  margin-top: 7%;
  z-index: 100;
}
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
#NewsArticle .newsBlock > .questions > .question > .answers > .answer {
  display: block;
  cursor: pointer;
  margin-bottom: 2px;
  position: relative;
  box-sizing: border-box;
}

#NewsArticle .newsBlock > .questions > .question > .answers > .answer > input {
  display: none;
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
  color: rgb(50, 50, 50);
  font-size: 1.1em;
  font-weight: bold;
  position: relative;
}
#NewsArticle .newsBlock > .questions > .question > .answers > .answer > .chart {
  background: rgb(0, 0, 0);
  height: 100%;
  position: absolute;
  top: 0;
  opacity: 0.1;
}
#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer:hover
  > .answerName {
  background: rgb(228, 228, 228);
}

#NewsArticle
  .newsBlock
  > .questions
  > .question
  > .answers
  > .answer
  > .active {
  color: rgb(85, 255, 0);
}
</style>