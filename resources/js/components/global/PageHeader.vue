<template>
  <nav class="navbar navbar-horizontal navbar-expand-lg navbar-light" style="z-index: 1050">
    <div class="container">
      <router-link to="/" class="navbar-brand mr-lg-3 text-primary display-name text-lg">
        {{ platform.display_name || platform.name }}
        <!-- <div class="logo"> 
          <img src="/images/starfolk_logo.png" width="60" height="60"> 
        </div> -->
      </router-link>
      <div class="navbar-collapse collapse" id="navbar-default-primary">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <router-link to="/">
              {{ platform.display_name || platform.name }}
            </router-link>
            </div>
            <div class="col-6 collapse-close">
              <i
                class="fas fa-times"
                data-toggle="collapse"
                role="button"
                data-target="#navbar-default-primary"
                aria-controls="navbar-default-primary"
                aria-expanded="false"
                aria-label="Toggle navigation"
              ></i>
            </div>
          </div>
        </div>
        <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
          <li class="nav-item">
            <router-link class="nav-link text-primary" to="/blog">
              {{
                trans.app.stories
              }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link text-primary" to="/memorial">
              {{
                trans.app.memorial
              }}
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a 
              class="nav-link text-primary dropdown-toggle" 
              href="#" id="watchDropdown" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="false"
            >
              {{ trans.app.watch }}
            </a>
            <div 
              class="dropdown-menu" 
              aria-labelledby="watchDropdown"
            >
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'video-testimonies' }}">
                {{ trans.app.testimonies }}
              </router-link>
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'video-docs' }}">
                {{ trans.app.video_docs }}
              </router-link>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a 
              class="nav-link text-primary dropdown-toggle" 
              href="#" id="readDropdown" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="false"
            >
              {{ trans.app.read }}
            </a>
            <div 
              class="dropdown-menu" 
              aria-labelledby="readDropdown"
            >
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'narratives' }}">
                {{ trans.app.narratives }}
              </router-link>
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'investigations' }}">
                {{ trans.app.investigations }}
              </router-link>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a 
              class="nav-link text-primary dropdown-toggle" 
              href="#" id="listenDropdown" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="false"
            >
              {{ trans.app.listen }}
            </a>
            <div 
              class="dropdown-menu" 
              aria-labelledby="listenDropdown"
            >
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'audio-testimonies' }}">
                {{ trans.app.testimonies }}
              </router-link>
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'audio-stories' }}">
                {{ trans.app.audio_stories }}
              </router-link>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a 
              class="nav-link text-primary dropdown-toggle" 
              href="#" id="resourcesDropdown" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="false"
            >
              {{ trans.app.resources }}
            </a>
            <div 
              class="dropdown-menu" 
              aria-labelledby="resourcesDropdown"
            >
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'trackerItems-main', params: { trackerId: 1 }}">
                {{ trans.app.maps }}
              </router-link>
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'blog-topic-posts', params: { slug: 'Infographics' }}">
                {{ trans.app.infographics }}
              </router-link>
              <router-link 
                class="dropdown-item text-primary" 
                :to="{name: 'resources-main'}">
                {{ trans.app.downloads }}
              </router-link>
            </div>
          </li>
          <li v-if="!CurrentTenant.user" class="nav-item d-block d-md-none">
            <a
              class="nav-link text-primary" 
              href="/login"
            >
              {{ trans.app.login }}
            </a>
          </li>
          <li v-if="CurrentTenant.user && !isUser" class="nav-item d-block d-md-none">
            <router-link class="nav-link text-primary" to="/admin">{{ trans.app.admin }}</router-link>
          </li>
          <li v-if="CurrentTenant.user" class="nav-item d-block d-md-none">
            <router-link class="nav-link text-primary" :to="`${isAdminPage ?'/admin' : ''}/settings`">{{ trans.app.settings }}</router-link>
          </li>
          <li v-if="CurrentTenant.user" class="nav-item d-block d-md-none">
            <a href="#!" class="nav-link text-primary" @click.prevent="sessionLogout">
              {{ trans.app.sign_out }}
            </a>
          </li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        <div class="my-auto ml-auto d-flex align-items-end align-middle">
          <slot name="action" />
        </div>
        <ul v-if="CurrentTenant.user && !isAdminPage" class="navbar-nav align-items-center mr-auto mr-md-0 d-none d-md-block">
          <li class="nav-item dropdown">
            <a 
              class="nav-link text-primary pr-0" 
              href="#" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="true">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img
                    :src="avatar"
                    :alt="user.name"
                  />
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">
                    {{ user.name }}
                  </span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-left text-primary">
              <div class="dropdown-header noti-title text-primary">
                <h6 class="text-overflow m-0 text-primary">{{ trans.app.welcome }}</h6>
              </div>
              <div v-if="!isUser" class="dropdown-divider"></div>
              <router-link v-if="!isUser" to="/admin" class="dropdown-item text-primary">
                <i class="ni ni-single-02"></i>
                <span>{{ trans.app.admin }}</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link :to="`${isAdminPage ?'/admin' : ''}/settings`" class="dropdown-item text-primary">
                <i class="ni ni-settings-gear-65"></i>
                <span>{{ trans.app.settings }}</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <a href="#!" class="dropdown-item text-primary" @click.prevent="sessionLogout">
                <i class="ni ni-user-run"></i> 
                <span>{{ trans.app.sign_out }}</span>
              </a>
            </div>
          </li>
        </ul>
        
        <a 
          v-if="!CurrentTenant.user"
          href="/login"
          class="btn btn-link text-decoration-none text-primary nav-item d-none d-md-block">
          {{ trans.app.login }}
        </a>

        <button
          class="navbar-toggler ml-2"
          type="button"
          data-toggle="collapse"
          data-target="#navbar-default-primary"
          aria-controls="navbar-default-primary"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
import $ from "jquery";
import { EventBus } from "../../bus";

export default {
  name: "page-header",

  data () {
    return {
      user: CurrentTenant.user,
      platform: CurrentTenant.platform,
      avatar: this.$root.avatar,
      token: this.getToken(),
      trans: JSON.parse(CurrentTenant.translations),
      trackers: CurrentTenant.trackers || [],
    };
  },

  mounted () {
    
  },

  watch: {
    "$root.avatar": function (url) {
      this.avatar = url;
    }
  },

  methods: {
    sessionLogout () {
      this.logout();
    }
  }
};
</script>

<style scoped>
/* @import url('https://fonts.googleapis.com/css2?family=Frijole&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap');

.display-name {
  font-family: 'Frijole', cursive;
  font-family: 'Bungee Shade', cursive;
} */
</style>
