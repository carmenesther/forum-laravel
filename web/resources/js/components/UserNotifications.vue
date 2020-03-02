<template>
    <li class="dropdown" v-if="notifications.length">

        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false"><i class="fas fa-bell"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li v-for="notification in notifications">
                    <a :href="notification.data.link"
                       v-text="notification.data.message"
                       @click="markAsRead(notification)"
                       class="dropdown-item"
                    ></a>
                </li>
            </ul>
    </li>
</template>

<script>
    export default {
        data() {
            return { notifications: false }
        },
        created() {
            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(response => this.notifications = response.data);
        },
        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }
</script>


