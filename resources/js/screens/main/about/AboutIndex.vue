<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>
    <section class="section-header pb-8 pb-lg-13 mb-4 mb-lg-6 bg-primary text-white m-0 pt-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 text-center">
            <h1 class="display-2 mb-3">{{ trans.app.who_is_trackly_for }}</h1>
            <p class="lead">
              {{ trans.app.who_is_trackly_for_explainer }}
            </p>
          </div>
        </div>
      </div>
      <div class="pattern bottom"></div>
    </section>
    <section class="section section-lg pt-0">
      <div class="container mt-n7 mt-lg-n13 z-2">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-6">
            <div
              class="card shadow-soft bg-white border-light animate-up-3 text-gray py-4 mb-5 mb-lg-0"
            >
              <div class="card-header text-center pb-0">
                <div class="icon icon-shape icon-shape-primary rounded-circle mb-3">
                  <i class="fas fa-map-marker"></i>
                </div>
                <h4 class="text-black">{{ trans.app.tracking }}</h4>
                <p>{{ trans.app.helps_find }}</p>
              </div>
              <div class="card-body">
                <ul class="list-group">
                  <li class="list-group-item d-flex px-0 pt-0 pb-2">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>{{ trans.app.tracking_features_1 }}</div>
                  </li>
                  <li class="list-group-item d-flex px-0 pb-1">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>
                      {{ trans.app.tracking_features_2 }}
                    </div>
                  </li>
                  <li class="list-group-item d-flex px-0 pb-1">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>
                      {{ trans.app.tracking_features_3 }}
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div
              class="card shadow-soft bg-white border-light animate-up-3 text-gray py-4 mb-5 mb-lg-0"
            >
              <div class="card-header text-center pb-0">
                <div class="icon icon-shape icon-shape-primary rounded-circle mb-3">
                  <i class="far fa-lightbulb"></i>
                </div>
                <h4 class="text-black">{{ trans.app.research }}</h4>
                <p>{{ trans.app.research_explainer }}</p>
              </div>
              <div class="card-body">
                <ul class="list-group">
                  <li class="list-group-item d-flex px-0 pt-0 pb-2">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>{{ trans.app.research_features_1 }}</div>
                  </li>
                  <li class="list-group-item d-flex px-0 pb-1">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>{{ trans.app.research_features_2 }}</div>
                  </li>
                  <li class="list-group-item d-flex px-0 pb-1">
                    <div class="icon icon-sm icon-success mr-4">
                      <i class="far fa-check-circle"></i>
                    </div>
                    <div>{{ trans.app.research_features_3 }}</div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section section-lg pt-0 line-bottom-light">
      <div class="container">
        <div class="row justify-content-center mb-5 mb-lg-6">
          <div class="col-12 col-md-8 text-center">
            <h1 class="display-3 mb-4">{{ trans.app.get_started_seconds }}</h1>
            <p class="lead">
              {{ trans.app.get_started_seconds_explainer }}
            </p>
          </div>
        </div>
        <div class="row">
          <div class="timeline timeline-six px-3 px-lg-0">
            <!-- Timeline Item 1 -->
            <div class="row no-gutters">
              <div class="col-lg">
                <!--spacer-->
              </div>
              <!-- timeline item 1 center image & middle line -->
              <div class="col-lg-1 text-center flex-column d-none d-lg-flex">
                <div class="row h-50">
                  <div class="col">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
                <span
                  class="d-none d-lg-block m-4 h4 lh-200 dot-separator bg-soft shadow-soft border border-light text-primary"
                >1</span>
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
              </div>
              <!-- timeline profile card -->
              <div class="col-lg py-2">
                <div class="card timeline-card bg-soft shadow-soft border-light p-3">
                  <div class="card-body p-4">
                    <h4 class="mb-3">
                      <span class="d-lg-none">1.</span> {{ trans.app.create_your_account }}
                    </h4>
                    <p
                      class="my-2"
                    >{{ trans.app.create_your_account_explainer }}</p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Timeline Item 2 -->
            <div class="row no-gutters">
              <!-- timeline profile card -->
              <div class="col-lg py-2">
                <div class="card left-timeline-card bg-soft shadow-soft border-light p-3">
                  <div class="card-body p-4">
                    <h4 class="mb-3">
                      <span class="d-lg-none">2.</span> {{ trans.app.browse_tracker }}
                    </h4>
                    <p class="my-2">{{ trans.app.browse_tracker_explainer }}</p>
                  </div>
                </div>
              </div>
              <!-- timeline item 2 center image & middle line -->
              <div class="col-lg-1 text-center flex-column d-none d-lg-flex">
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
                <span
                  class="m-4 h4 lh-200 dot-separator bg-soft shadow-soft border border-light text-primary"
                >2</span>
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
              </div>
              <div class="col-lg">
                <!--spacer-->
              </div>
            </div>
            <!-- Timeline Item 3 -->
            <div class="row no-gutters">
              <div class="col-lg">
                <!--spacer-->
              </div>
              <!-- timeline item 3 center image & middle line -->
              <div class="col-lg-1 text-center flex-column d-none d-lg-flex">
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
                <span
                  class="m-4 h4 lh-200 dot-separator bg-soft shadow-soft border border-light text-primary"
                >3</span>
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
              </div>
              <!-- timeline profile card -->
              <div class="col-lg py-2">
                <div class="card timeline-card bg-soft shadow-soft border-light p-3">
                  <div class="card-body p-4">
                    <h4 class="mb-3">
                      <span class="d-lg-none">3.</span> {{ trans.app.submit_item_to_tracker }}
                    </h4>
                    <p class="my-2">
                      {{ trans.app.submit_item_to_tracker_explainer }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Timeline Item 4 -->
            <div class="row no-gutters">
              <!-- timeline profile card -->
              <div class="col-lg py-2">
                <div class="card left-timeline-card bg-soft shadow-soft border-light p-3">
                  <div class="card-body p-4">
                    <h4 class="mb-3">
                      <span class="d-lg-none">4.</span> {{ trans.app.track }}
                    </h4>
                    <p class="my-2">{{ trans.app.track_explainer }}</p>
                  </div>
                </div>
              </div>
              <!-- timeline item 4 center image & middle line -->
              <div class="col-lg-1 text-center flex-column d-none d-lg-flex">
                <div class="row h-50">
                  <div class="col middle-line">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
                <span
                  class="m-4 h4 lh-200 dot-separator bg-soft shadow-soft border border-light text-primary"
                >4</span>
                <div class="row h-50">
                  <div class="col">&nbsp;</div>
                  <div class="col">&nbsp;</div>
                </div>
              </div>
              <div class="col-lg">
                <!--spacer-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "contact-index",
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations)
    };
  },
  mounted() {
    NProgress.done();
  },
  methods: {
    
  }
};
</script>

<style scoped></style>