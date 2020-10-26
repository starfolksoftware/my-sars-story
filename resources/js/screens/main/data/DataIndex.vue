<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main class="mt-5 col-md-10 mx-auto">
      <h3 class="title mb-5">
        {{ trans.app.datasets }}
      </h3>
      <div class="row">
        <div class="col-md-8">
          <div class="w-100">
            <input 
              class="form-control" 
              type="text" 
              placeholder="Search" 
              aria-label="Search"
              v-model="query"
            >
          </div>
          <div
            v-for="(dataset, $index) in datasets"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <router-link
                  :to="{name: 'data-show', params: { id: dataset.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ dataset.title }}</router-link>
              </p>
              <p class="mb-1" v-if="dataset.description" v-html="trim(dataset.description, 200)"></p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.author }} {{ dataset.user.name }} |</span> 
                <span>{{ dataset.resources.length }} {{ trans.app.resources }}</span>
              </p>
              <p class="text-muted mb-0">
                ― {{ trans.app.updated }} {{ moment(dataset.updated_at).locale(CurrentTenant.locale).fromNow() }}
              </p>
            </div>
          </div>

          <infinite-loading 
            :identifier="infiniteId"
            @infinite="fetchData" 
            spinner="spiral" 
            style="position: relative; top: 0">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">
                  <span>
                    {{trans.app.you_have_no_results}}
                  </span>
                </p>
              </div>
            </div>
          </infinite-loading>
        </div>
        <div class="col-md-4 d-none d-md-block">
          <div class="card mb-5">
            <div class="card-header bg-danger text-white">
              {{ trans.app.topics }}
            </div>
            <ul class="list-group list-group-flush">
              <li 
                class="list-group-item"
                v-for="(topic, index) in topics" :key="index">
                <input 
                  type="radio" 
                  :value="topic.name"
                  :id="'topic-'+topic.id" 
                  v-model="filterName" 
                  @change="setFilter('topics', topic.id)">
                <label :for="'topic-'+topic.id">{{ topic.name }}</label>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header bg-danger text-white">
              {{ trans.app.licenses }}
            </div>
            <ul class="list-group list-group-flush">
              <li 
                class="list-group-item"
                v-for="(license, index) in licenses" :key="index">
                <input 
                  type="radio" 
                  :value="license.name"
                  :id="'license-'+license.id" 
                  v-model="filterName" 
                  @change="setFilter('license', license.id)">
                <label :for="'license-'+license.id">{{ license.name }}</label>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading"

export default {
  name: "datasets-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      datasets: [],
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
      licenses: [],
      topics: [],
      currentFilters: [],
      filter: "",
      filterId: "",
      filterName: "",
      query: "",
      url: "/api/v1/data",
      from: "",
      to: "",
      total: "",
    };
  },

  created() {
    this.fetchFilters()
    
    this.$nextTick(() => {
      if(this.$route.params.filter &&
        this.$route.params.filterId) {
        this.setFilter(
          this.$route.params.filter,
          this.$route.params.filterId
        )
        this.filterName = this.$route.params.filterName
      }

      if(this.$route.query.query) {
        this.setQuery(this.$route.query.query)
      }
    })
    
  },

  watch: {
    filter: function (val) {
      this.filterId = ""
    },

    filterId: function (val) {
      if (val === "") {
        this.url = "/api/v1/data"
      } else {
        this.url = `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}`
      }

      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    },

    query: function (val) {
      if (val === "") {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}` :
          "/api/v1/data"
      } else {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}&&query=${this.query}` :
          `/api/v1/data?query=${this.query}`
      }

      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get(this.url, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.datasets.push(...response.data.data);
            this.from = response.data.from
            this.to = response.data.to
            this.total = response.data.total

            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    },

    fetchFilters() {
      // fetch agencies
      this.request()
        .get("/api/v1/datalicenses?all=1")
        .then(response => {
          this.licenses = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch topics
      this.request()
        .get("/api/v1/datatopics?all=1")
        .then(response => {
          this.topics = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
    },

    setFilter(filter, filterId) {
      this.filter = filter
      this.filterId = filterId

      if (this.filterId === "") {
        this.url = "/api/v1/data"
      } else {
        this.url = `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}`
      }

      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    },

    setQuery(query) {
      this.query = query
      if (query === "") {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}` :
          "/api/v1/data"
      } else {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}&&query=${this.query}` :
          `/api/v1/data?query=${this.query}`
      }

      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    }
  }
};
</script>

<style scoped></style>
