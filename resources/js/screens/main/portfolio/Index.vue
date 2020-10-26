<template>
  <div>
    <router-link 
      class="btn btn-sm btn-outline-default position-fixed mt-3 ml-3" 
      :to="{ name: 'home' }" style="z-index: 1000">
      <span class="fas fa-long-arrow-alt-left ml-2"></span>
      {{ trans.app.home }}
    </router-link>
    <section class="section d-md-flex">
      <div class="col-12 col-md-6 flex-column h-100vh" style="background-image: url('/images/portfolio/bg/bg4.jpg');">
        <div class="row h-100 p-5">
          <div class="mx-auto my-auto text-center">
            <img 
              src="/images/portfolio/amina.png" 
              class="img-fluid"
              alt="amina logo">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 flex-column h-100vh p-5 p-md-9">
        <div class="row h-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">
              AminaTheBot
            </h1>
            <p class="lead">
              A multilingual AI-powered Chatbot built to answer covid19 
              related questions in Hausa, Yoruba, Igbo, 
              Pidgin and English.
            </p>
            <a 
              class="btn btn-sm btn-outline-default" 
              href="https://aminathebot.starfolksoftware.com/"
              target="_blank">
              {{ trans.app.view_project }}
              <span class="fas fa-long-arrow-alt-right mr-2"></span>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section class="section d-md-flex">
      <div class="col-12 col-md-6 flex-column h-100vh p-5 p-md-9">
        <div class="row h-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">
              Offline-first ERP Software
            </h1>
            <p class="lead">
              An Enterprise Resource Planning for Mudatex - one of the biggest, 
              if not the biggest, retail companies in Kano State. 
              It is a desktop offline-first application.
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 flex-column h-100vh" style="background-image: url('/images/portfolio/bg/bg1.jpg');">
        <div class="row h-100 p-5">
          <div class="mx-auto my-auto text-center">
            <img 
              src="/images/portfolio/mudatex_erp.png" 
              class="img-fluid img-thumbnail"
              alt="amina logo">
          </div>
        </div>
      </div>
    </section>
    <section class="section d-md-flex">
      <div class="col-12 col-md-6 flex-column h-100vh" style="background-image: url('/images/portfolio/bg/bg7.jpg');">
        <div class="row h-100 p-5">
          <div class="mx-auto my-auto text-center">
            <img 
              src="/images/portfolio/pressattack.png" 
              class="img-fluid img-thumbnail"
              alt="amina logo">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 flex-column h-100vh p-5 p-md-9">
        <div class="row h-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">
              PressAttackTracker
            </h1>
            <p class="lead">
              Press Attack Tracker is a platform to track and 
              report attacks on the press. The platform provides a map of 
              threats and attack on the press thus providing data for periodic 
              review and also serve as advocacy tool for Press Freedom in 
              the wider Nigerian society.
            </p>
            <a 
              class="btn btn-sm btn-outline-default" 
              href="https://pressattack.ng/"
              target="_blank">
              {{ trans.app.view_project }}
              <span class="fas fa-long-arrow-alt-right mr-2"></span>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section class="section d-md-flex">
      <div class="col-12 col-md-6 flex-column h-100vh p-5 p-md-9">
        <div class="row h-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">
              AsariTheBot
            </h1>
            <p class="lead">
              A Chatbot that collects report of attacks on journalists. 
              It is an add-on to PressAttackTracker.
            </p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 flex-column h-100vh" style="background-image: url('/images/portfolio/bg/bg2.jpg');">
        <div class="row h-100 pl-5 pr-5">
          <div class="col-md-6 mx-auto my-auto text-center">
            <img 
              src="/images/portfolio/asarithebot.png" 
              class="img-fluid img-thumbnail"
              alt="amina logo">
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "portfolio-index",
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
    };
  },
  mounted() {
    NProgress.done();
  }
};
</script>

<style>

</style>