<template>
    <article id="NewsArticle">
        <div class="leftCol">
          <div class="newsBlock" v-for="n in news" :key="'news'+n.id">
            <div class="topic">
              <p v-if="n.type == 'newProfile'"><router-link :to="{ name: 'profile', params: { id: n.authorId }}">{{n.authorSurname}} {{n.authorName}} {{n.authorPatronymic}}</router-link> зареєструвався.</p>
              <p v-else>{{n.topic}}</p>
              <div class="isCommand" title="Бачить лише провід куреня" v-if="n.accessRights=='command'"></div>
            </div>
            <div class="description">
              <p>{{n.description}}</p>
            </div>
            <div class="question" v-for="question in n.questions" :key="'question'+question.id">
              <p>{{question.question}}</p>
              <!-- <p>{{question}}</p> -->
              <div class="answers">
                <p @click="setAnswer(answer.id)" v-for="answer in question.answers" :key="'answer'+answer.id">{{answer.answer}}</p>
              </div>
            </div>
          </div>
        </div>
    </article>
</template>

<script>
var NewsData = {
  news: ""
};

export default {
  name: "NewsArticle",
  data: function() {
    return NewsData;
  },
  created: function() {
    $.ajax({
      url: "../orlyky/server/get/news.php",
      type: "POST",
      dataType: "json",

      success: function(data) {
        NewsData.news = data.news;
      },

      error: function() {
        alert("error");
      }
    });
  },
  methods: {
    setAnswer: function(answerId) {
      $.ajax({
        url: "../orlyky/server/set/answer.php",
        type: "POST",
        dataType: "json",
        data: {
          answerId: answerId
        },

        success: function(data) {
          alert(data.response);
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};

$(window).scroll(function() {
  alert("s");
  if ($(window).scrollTop() == $(document).height() - $(window).height()) {
    $.ajax({
      url: "../orlyky/server/get/news.php",
      type: "POST",
      dataType: "json",

      success: function(data) {},

      error: function() {
        alert("error");
      }
    });
  }
});
</script>

<style scoped>
#NewsArticle {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  height: 100%;
  margin-top: 7%;
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
#NewsArticle .newsBlock > .description {
}
#NewsArticle .newsBlock > .description > p {
  padding: 1%;
  box-sizing: border-box;
}
</style>
