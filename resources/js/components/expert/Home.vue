<template>
  <div class="container-fluid">
    <!-- Expert -->
    <div class="row mb-3">
      <div class="col-md-4">
        <div class="d-flex flex-row">
          <div class="p-0 w-25">
            <img src="/avatar/avatar.png" class="img-thumbnail border-0" />
          </div>
          <div class="pl-3 pt-2 pr-2 pb-2 w-75 border-left">
            <h4 class="text-primary">{{ user_name }}</h4>
            <h5 class="text-info">Expert</h5>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <h1>
                  <router-link to="/expert/method-details">
                    <img
                      src="/avatar/btnimg/plant_grafting.jpg"
                      class="rounded-circle"
                      alt="PG"
                      width="100"
                      height="100"
                    />
                  </router-link>
                </h1>
              </div>
              <div class="col-md-4">
                <h1>
                  <router-link to="/expert/plant-detail">
                    <img
                      src="/avatar/btnimg/plant_details.jpg"
                      class="rounded-circle"
                      alt="PG"
                      width="100"
                      height="100"
                    />
                  </router-link>
                </h1>
              </div>
              <div class="col-md-4">
                <h1>
                  <router-link to="/expert/graft-details">
                    <img
                      src="/avatar/btnimg/graft_techniques.jpg"
                      class="rounded-circle"
                      alt="PG"
                      width="100"
                      height="100"
                  /></router-link>
                </h1>
              </div>
              <div class="col-md-4">
                <h1>
                  <router-link to="/expert/plant-name">
                    <img
                      src="/avatar/btnimg/plant_name.jpg"
                      class="rounded-circle"
                      alt="PG"
                      width="100"
                      height="100"
                    />
                  </router-link>
                </h1>
              </div>
              <div class="col-md-4">
                <h1>
                  <router-link to="/expert/variety">
                    <img
                      src="/avatar/btnimg/variety.jpg"
                      class="rounded-circle"
                      alt="PG"
                      width="100"
                      height="100"
                    />
                  </router-link>
                </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div class="row" v-if="comments">
      <!--  -->

      <div class="be-comment-block">
        <h1 class="comments-title">
          Comments ({{ comments == null ? "0" : comments.length }})
        </h1>
        <!--  -->
        <template v-for="com in comments">
          <div class="be-comment">
            <div class="be-img-comment">
              <a href="#">
                <img src="/avatar/avatar.png" alt="" class="be-ava-comment" />
              </a>
            </div>
            <div class="be-comment-content">
              <span class="be-comment-name">
                <a href="#">{{ com.name == null ? "anonymous" : com.name }}</a
                ><br />
              </span>
              <span class="be-comment-time">
                <time-ago :datetime="com.created_at" refresh :long="true" />
              </span>

              <p class="be-comment-text">
                <small
                  ><strong>{{ com.plant }} </strong> <br />
                  {{ com.variety }} </small
                ><br /><br />
                {{ com.comment }}
              </p>
            </div>
          </div>
        </template>
        <!--  -->
      </div>

      <!--  -->
    </div>
    <!--  -->
  </div>
</template>

<script>
import { TimeAgo } from "vue2-timeago";
import "vue2-timeago/dist/vue2-timeago.css";
export default {
  data() {
    return {
      user_name: "",
      comments: [],
      errors: [],
    };
  },
  mounted() {
    this.getuser();
    this.getcomments();
  },

  components: { TimeAgo },

  methods: {
    getuser() {
      axios.get("/expert/get-user-details").then(({ data }) => {
        this.user_name = data;
      });
    },
    getcomments() {
      axios.get("/expert/get-dash-comments").then(({ data }) => {
        this.comments = data;
      });
    },
  },
};
</script>
<style scoped>
.be-comment-block {
  margin-bottom: 50px !important;
  border: 1px solid #edeff2;
  border-radius: 2px;
  padding: 50px 70px;
  border: 1px solid #ffffff;
}

.comments-title {
  font-size: 16px;
  color: #262626;
  margin-bottom: 15px;
  font-family: "Conv_helveticaneuecyr-bold";
}

.be-img-comment {
  width: 60px;
  height: 60px;
  float: left;
  margin-bottom: 15px;
}

.be-ava-comment {
  width: 60px;
  height: 60px;
  border-radius: 50%;
}

.be-comment-content {
  margin-left: 80px;
}

.be-comment-content span {
  display: inline-block;
  width: 49%;
  margin-bottom: 15px;
}

.be-comment-name {
  font-size: 13px;
  font-family: "Conv_helveticaneuecyr-bold";
}

.be-comment-content a {
  color: #383b43;
}

.be-comment-content span {
  display: inline-block;
  width: 49%;
  margin-bottom: 15px;
}

.be-comment-time {
  text-align: right;
}

.be-comment-time {
  font-size: 11px;
  color: #b4b7c1;
}

.be-comment-text {
  font-size: 13px;
  line-height: 18px;
  color: #7a8192;
  display: block;
  background: #f6f6f7;
  border: 1px solid #edeff2;
  padding: 15px 20px 20px 20px;
}

.form-group.fl_icon .icon {
  position: absolute;
  top: 1px;
  left: 16px;
  width: 48px;
  height: 48px;
  background: #f6f6f7;
  color: #b5b8c2;
  text-align: center;
  line-height: 50px;
  -webkit-border-top-left-radius: 2px;
  -webkit-border-bottom-left-radius: 2px;
  -moz-border-radius-topleft: 2px;
  -moz-border-radius-bottomleft: 2px;
  border-top-left-radius: 2px;
  border-bottom-left-radius: 2px;
}

.form-group .form-input {
  font-size: 13px;
  line-height: 50px;
  font-weight: 400;
  color: #b4b7c1;
  width: 100%;
  height: 50px;
  padding-left: 20px;
  padding-right: 20px;
  border: 1px solid #edeff2;
  border-radius: 3px;
}

.form-group.fl_icon .form-input {
  padding-left: 70px;
}

.form-group textarea.form-input {
  height: 150px;
}
</style>