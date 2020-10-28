import md5 from "md5";
import numeral from "numeral";

export default {
  computed: {
    CurrentTenant() {
      return window.CurrentTenant;
    },

    isCustomRole() {
      return this.CurrentTenant.user && 
        this.CurrentTenant.user.roles.length > 0;
    },

    isAdmin() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Admin");
    },

    isUser() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("User");
    },

    isWriter() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Writer");
    },

    isEditor() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Editor");
    },

    isDataEntry() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Data Curator");
    },

    isDataEditor() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Data Researcher & Editor");
    },

    isAdminPage() {
      let patt = new RegExp("/admin");
      return patt.test(this.$route.path);
    },

    isLoggedIn() {
      return this.CurrentTenant.user && this.CurrentTenant.user.name
    }
  },

  methods: {
    slugify(text) {
      return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/--+/g, "-");
    },

    makeVariable(text) {
      return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "_")
        .replace(/[^\w\-]+/g, "")
        .replace(/--+/g, "_");
    },

    suffixedNumber(number) {
      if (number < 900) {
        return number;
      } else {
        return numeral(number).format("0.0a");
      }
    },

    trim(string, length = 70) {
      return _.truncate(string, {
        length: length
      });
    },

    defaultGravatar(email, size = 200) {
      let hash = md5(email.trim().toLowerCase());

      return "https://secure.gravatar.com/avatar/" + hash + "?s=" + size;
    },

    mediaUploadPath() {
      return "/api/v1/media/uploads";
    },

    mediaFormat(path) {
      let pathArray = path.split('/')
      let lastElementOfPathArray = pathArray[pathArray.length-1].split('.')
      let format = lastElementOfPathArray[lastElementOfPathArray.length-1]

      return format
    },

    resourceUploadPath() {
      return "/api/v1/resource/uploads"
    },

    hasPermission(permission) {
      return CurrentTenant.user.permissions.includes(permission);
    },

    hasSubapp(subapp) {
      return CurrentTenant.platform.subapps.map((subapp) => subapp.name).includes(subapp);
    },

    downloadBlob(blob, filename) {
      alert(typeof blog)
      // Create an object URL for the blob object
      // const url = URL.createObjectURL(blob);

      // Create a new anchor element
      const a = document.createElement('a');

      // Set the href and download attributes for the anchor element
      // You can optionally set other attributes like `title`, etc
      // Especially, if the anchor element will be attached to the DOM
      a.href = blob;
      a.download = filename || 'download';

      // Click handler that releases the object URL after the element has been clicked
      // This is required for one-off downloads of the blob content
      const clickHandler = () => {
        setTimeout(() => {
          URL.revokeObjectURL(url);
          this.removeEventListener('click', clickHandler);
        }, 150);
      };

      // Add the click event listener on the anchor element
      // Comment out this line if you don't want a one-off download of the blob content
      a.addEventListener('click', clickHandler, false);

      // Programmatically trigger a click on the anchor element
      // Useful if you want the download to happen automatically
      // Without attaching the anchor element to the DOM
      // Comment out this line if you don't want an automatic download of the blob content
      a.click();

      // Return the anchor element
      // Useful if you want a reference to the element
      // in order to attach it to the DOM or use it in some other way
      return a;
    },

    prettyJSON: function (json) {
      if (json) {
        json = JSON.stringify(json, undefined, 4);
        json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
          var cls = 'number';
          if (/^"/.test(match)) {
            if (/:$/.test(match)) {
              cls = 'key';
            } else {
              cls = 'string';
            }
          } else if (/true|false/.test(match)) {
            cls = 'boolean';
          } else if (/null/.test(match)) {
            cls = 'null';
          }
          return '<span class="' + cls + '">' + match + '</span>';
        });
      }
    },

    isPreviewable: (extension) => ['csv', 'xls', 'xlsx'].indexOf(extension) !== -1,

    /*
      QueryableWorker instances methods:
        * sendQuery(queryable function name, argument to pass 1, argument to pass 2, etc. etc): calls a Worker's queryable function
        * postMessage(string or JSON Data): see Worker.prototype.postMessage()
        * terminate(): terminates the Worker
        * addListener(name, function): adds a listener
        * removeListener(name): removes a listener
      QueryableWorker instances properties:
        * defaultListener: the default listener executed only when the Worker calls the postMessage() function directly
      */
    QueryableWorker(url, defaultListener, onError) {
      var instance = this,
        worker = new Worker(url),
        listeners = {};

      this.defaultListener = defaultListener || function () { };

      if (onError) { worker.onerror = onError; }

      this.postMessage = function (message) {
        worker.postMessage(message);
      }

      this.terminate = function () {
        worker.terminate();
      }

      this.addListener = function (name, listener) {
        listeners[name] = listener;
      }

      this.removeListener = function (name) {
        delete listeners[name];
      }

      /* 
        This functions takes at least one argument, the method name we want to query.
        Then we can pass in the arguments that the method needs.
      */
      this.sendQuery = function () {
        if (arguments.length < 1) {
          throw new TypeError('QueryableWorker.sendQuery takes at least one argument');
          return;
        }
        worker.postMessage({
          'queryMethod': arguments[0],
          'queryMethodArguments': Array.prototype.slice.call(arguments, 1)
        })
      }

      worker.onmessage = (event) => {
        if (event.data instanceof Object &&
          event.data.hasOwnProperty('queryMethodListener') &&
          event.data.hasOwnProperty('queryMethodArguments')) {
          listeners[event.data.queryMethodListener].apply(instance, event.data.queryMethodArguments)
        } else {
          this.defaultListener.call(instance, event.data)
        }
      }
    },

    scrollToTop() {
      window.scrollTo(0, 0)
    },

    /**
     * Parse a given url.
     *
     * @param url
     * @link https://www.abeautifulsite.net/parsing-urls-in-javascript
     */
    parseURL(url) {
      let parser = document.createElement('a'),
        searchObject = {},
        queries,
        split,
        i;

      parser.href = url;
      queries = parser.search.replace(/^\?/, '').split('&')

      for (i = 0; i < queries.length; i++) {
        split = queries[i].split('=')
        searchObject[split[0]] = split[1]
      }

      return {
        protocol: parser.protocol,
        host: parser.host,
        hostname: parser.hostname,
        port: parser.port,
        pathname: parser.pathname,
        search: parser.search,
        searchObject: searchObject,
        hash: parser.hash
      }
    },

    publicIdentifier(post) {
        switch (CurrentTenant.identifier) {
            case 'id':
                return post.user_id

            case 'username':
                return post.user_meta.username

            default:
                break;
        }
    },

    deleteMedia(path) {
      return this.request()
        .delete("/api/v1/media/uploads", {
          params: {
            path
          }
        })
    }
  },
};
