<template>
  <multiselect
    v-model="value"
    :placeholder="trans.app.select_some_topics"
    :tag-placeholder="trans.app.add_a_new_topic"
    :options="options"
    :multiple="true"
    :taggable="true"
    @input="onChange"
    @topic="addTopic"
    label="name"
    track-by="id"
    style="cursor: pointer"
  />
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
  props: {
    topics: {
      type: Array,
      required: false
    },
    tagged: {
      type: Array,
      required: false
    }
  },

  components: {
    Multiselect
  },

  data() {
    const allTopics = this.topics.map(obj => {
      let filtered = {};

      filtered["name"] = obj.name;
      filtered["id"] = obj.id;

      return filtered;
    });

    return {
      options: allTopics,
      value: this.tagged ? this.tagged : [],
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  methods: {
    onChange(value, id) {
      this.$store.dispatch("setDatasetTopics", value);

      this.update();
    },

    addTopic(searchQuery) {
      const topic = {
        name: searchQuery,
        id: null
      };

      this.options.push(topic);
      this.value.push(topic);

      this.$store.dispatch("setDatasetTopics", this.value);

      this.update();
    },

    update() {
      this.$parent.update();
    }
  }
};
</script>
