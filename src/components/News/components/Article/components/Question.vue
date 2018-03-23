<template>
    <div id="Question">
        <p>{{question.question}}</p>
        <div class="answers">
        <div class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==0">
            <input @click="setAnswer(answer.id, question.id)" type="radio" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.usersAnswers[0]">
            <label :for="'answer'+answer.id"><p :class="{active: question.usersAnswers[0]==answer.id}">{{answer.answer}}</p></label>
        </div>
        <div class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==1">
            <input type="checkbox" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.usersAnswers">
            <label :for="'answer'+answer.id"><p :class="{active: question.usersAnswers[question.usersAnswers.indexOf(answer.id)]}">{{answer.answer}}</p></label>
        </div>
        <div @click="setAnswer(question.usersAnswers, question.id)" v-if="question.type==1">Проголосувати</div>
        <div class="answer">
            <router-link class="answerName" :to="{ path: `/profile/${authorId}/accept`}" v-if="question.type==2">Так</router-link>
        </div>
        <label class="answer" v-for="answer in question.answers" :key="'answer'+answer.id" v-if="question.type==2">
            <input @click="setAnswer(answer.id, question.id)" type="radio" :name="'answer'+answer.id" :id="'answer'+answer.id" :value="answer.id" v-model="question.usersAnswers[0]">
            <div class="answerName" :for="'answer'+answer.id" :class="{active: question.usersAnswers[0]==answer.id}">{{answer.answer}}</div>
            <div class="chart" v-if="chartWidth" :style="{width: 100/users.length*answer.voted.length+'%'}"></div>
            {{question.id}}
        </label>
        </div>
    </div>
</template>
<script>
var QuestionData = {
  id: "",
  question: "",
  users: "",
  chartWidth: 50
};

export default {
  name: "Question",
  props: ["questionId", "authorId"],
  data: function() {
    return QuestionData;
  },
  created: function() {
    this.id = this.questionId;
    $.ajax({
      url: "../orlyky/server/get/question.php",
      type: "POST",
      dataType: "json",
      data: {
        id: QuestionData.id
      },

      success: function(data) {
        QuestionData.question = data.question;
        QuestionData.users = data.users;
      },

      error: function() {
        alert("error");
      }
    });
  }
  //   updated: function() {
  //     console.log("up");
  //   }
};
</script>

<style scoped>
#Question > p {
  display: block;
  padding: 1%;
  box-sizing: border-box;
}
#Question > .answers > .answer {
  display: block;
  cursor: pointer;
  margin-bottom: 2px;
  position: relative;
  box-sizing: border-box;
}

#Question > .answers > .answer > input {
  display: none;
}
#Question > .answers > .answer > .answerName {
  display: block;
  padding: 0.5%;
  box-sizing: border-box;
  color: rgb(50, 50, 50);
  font-size: 1.1em;
  font-weight: bold;
  position: relative;
}
#Question > .answers > .answer > .chart {
  background: rgb(0, 0, 0);
  height: 100%;
  position: absolute;
  top: 0;
  opacity: 0.1;
}
#Question > .answers > .answer:hover > .answerName {
  background: rgb(228, 228, 228);
}

#Question > .answers > .answer > .active {
  color: rgb(85, 255, 0);
}
</style>