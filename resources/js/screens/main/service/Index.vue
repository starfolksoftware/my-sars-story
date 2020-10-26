<template>
  <div>
    <page-header></page-header>

    <main>
      <div class="container">
        <section class="section section-lg mt-9 mb-9">
          <h1 class="display-4 font-weight-700">Execution trumps all</h1>
          <p class="lead">
            Diligent accomplishes more than intelligent. Intelligent 
            accomplishes faster than diligent. We are both. We provide 
            the most fitting technological solutions to your problems. 
            We are excited to turn your ideas into stunning and usable products.
          </p>
        </section>

        <services :services="CurrentTenant.services" />

        <section class="section section-lg mt-5 mb-5">
          <h1 class="display-3 font-weight-700">How we work</h1>
          <div class="container mt-5">
            <div class="row">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      1. Definition, Discovery &amp; Scope
                    </h5>
                    <p class="card-text mt-4">
                      Understanding your business, vision and your expectations 
                      is an integral part of the app development process. 
                      We work with you to identify the project details and 
                      determine the features, functions, content categories, 
                      aesthetic requirements, technical implications, 
                      timeline and other specifications.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      2. Site Mapping &amp; UX
                    </h5>
                    <p class="card-text mt-4">
                      For complex sites, we use wire frames to map out the architecture and flow of your project to ensure that everyone understands how screens and content relate to one another. We will also use this process to identify the nature and source of all the content for the application.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      3. Design Phase
                    </h5>
                    <p class="card-text mt-4">
                      Once the features, functions and other specifications are defined, we move on to the design stage. The time required for this phase will vary depending on the complexity of the project but we keep designing until you are happy with what we produce.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      4. Development
                    </h5>
                    <p class="card-text mt-4">
                      Upon approval of the design, we move on to the meat and potatoes of your website. We write code using the best industry practices to produce a clean, search engine friendly(in the case of a website) apps. We also make sure to keep you informed on where we are in relation to the project schedule.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      5. Testing &amp; Training
                    </h5>
                    <p class="card-text mt-4">
                      We tinker and test to ensure that everything is working as required and that your application is ready for production. We also train you on how to use the application’s content management system (CMS) so that you can manage and edit the website according to the changing needs of your business.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      6. Deployment
                    </h5>
                    <p class="card-text mt-4">
                      App! But the launch of your application is not the end of our commitment. We provide free technical support for a period of time and are always available to make additions and improvements, as required.
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      7. Maintenance &amp; Support
                    </h5>
                    <p class="card-text mt-4">
                      Your website is often the first introduction that anyone gets about who you are and what you do. Our webmaster services will help to make sure that it is kept up-to-date with accurate, fresh, properly organised information on pages that load quickly. We also offer 1 year of FREE technical support. Nobody does that!
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <h5 class="h2 card-title mb-0">
                      8. SEO &amp; Marketing
                    </h5>
                    <p class="card-text mt-4">
                      If you build it, will they come? Not really! Not if they can’t find you on Google. We provide a range of online marketing services to help make your site visible on the major search engines and in local search directories for terms that are relevant to what you do
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="section section-lg mt-5 mb-5">
          <h1 class="display-3 font-weight-700">Our Principles</h1>
          <div class="container mt-5">
            <div class="row">
              <div class="col-md-4 mb-5">
                <div class="mb-3">
                  <i class="ni ni-bold-right text-primary"></i>
                </div>
                <div class="info">
                  <h6 class="text-uppercase text-xl font-weight-700">
                    Customer Oriented
                  </h6>
                  <p class="lead opacity-8">
                    Every business decision we make has one ultimate goal - Customer satisfaction. 
                    Helping our customers meet their long term needs and wants is at the core 
                    of our sales and customer-relations.
                  </p>
                </div>
              </div>

              <div class="col-md-4 mb-5">
                <div class="mb-3">
                  <i class="ni ni-check-bold text-primary"></i>
                </div>
                <div class="info">
                  <h6 class="text-uppercase text-xl font-weight-700">
                    Value First
                  </h6>
                  <p class="lead opacity-8">
                    We pride in delivering the right product on time within 
                    budget. <i>"No one wants code, only value is wanted"</i>. 
                    Success for us is the delievery of customer values.
                  </p>
                </div>
              </div>

              <div class="col-md-4 mb-5">
                <div class="mb-3">
                  <i class="ni ni-box-2 text-primary"></i>
                </div>
                <div class="info">
                  <h6 class="text-uppercase text-xl font-weight-700">
                    After Sales Package
                  </h6>
                  <p class="lead opacity-8">
                    We understand that a software product is never a 
                    100% complete. After deployment, we available for bug 
                    fixes, feature request implementation, staff-training, 
                    onsite and offsite support.
                  </p>
                </div>
              </div>

              <div class="col-md-4 mb-5">
                <div class="mb-3">
                  <i class="ni ni-paper-diploma text-primary"></i>
                </div>
                <div class="info">
                  <h6 class="text-uppercase text-xl font-weight-700">
                    Standard Practices
                  </h6>
                  <p class="lead opacity-8">
                    We develop iteratively, manage requirements, use 
                    component architecture, model software visually, verify 
                    quality and control change.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>


        <section class="section">
          <div class="row">
            <div class="col-5">
              <img class="img-fluid" src="/images/p3.jpg" alt="">
            </div>
            <div class="col-7">
              <img class="img-fluid" src="/images/p2.jpg" alt="">
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-7">
              <img class="img-fluid" src="/images/p1.jpg" alt="">
            </div>
            <div class="col-5">
              <img class="img-fluid" src="/images/p4.jpeg" alt="">
            </div>
          </div>
        </section>


        <section class="section section-lg mt-9 mb-9 text-center">
          <h1 class="font-weight-700">Let's talk</h1>
          <p class="lead col-md-6 mx-auto">
            We would love to hear about your ideas; 
            What problem are you trying to solve?.
          </p>
          <router-link to="/contact" class="btn btn-rounded btn-outline-info">
            Talk to us
          </router-link>
        </section>
      </div>
    </main>

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import Services from './Services'

export default {
  name: "service-index",

  components: {
    Services
  },

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