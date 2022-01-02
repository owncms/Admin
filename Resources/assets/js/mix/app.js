import Vue from 'vue';

Vue.config.productionTip = false;
new Vue({
    el: '#admin-panel',
    data: {
      searchPhrase: '',
    },
    watch: {
      searchPhrase(query, old_query) {
          console.log(query, old_query, 1);
      }
    },
    methods: {
        toggleMenu() {
            const sidebar = document.getElementById('sidebar-menu-content');
            const mainContent = document.getElementById('main-content');
            if (!sidebar.classList.contains('active')) {
                sidebar.classList.add('active');
                mainContent.classList.remove('full-width-content');
            } else {
                sidebar.classList.remove('active');
                mainContent.classList.add('full-width-content');
            }
        },
        setActiveSidebarElement(event) {
            let el = event.target.parentNode;
            if (el.classList.contains('active')) {
                el.classList.remove('active');
            } else {
                el.classList.add('active');
            }
        },
        userInfoToggle(active = false) {
            const userInfo = document.getElementById('user-info');
            if (active) {
                userInfo.classList.add('active');
            } else {
                userInfo.classList.remove('active');
            }
        }
    }
})


