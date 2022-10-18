<template>
    <div class="wrapper-page">
        <div class="page-heading">
            <div class="page-details">
                <v-toolbar outlined color="grey lighten-3" elevation="0">
                    <v-toolbar-title>
                        <v-app-bar-nav-icon  @click="drawer = !drawer"></v-app-bar-nav-icon>
                      
                        Usuarios
                    </v-toolbar-title>
                </v-toolbar>
            </div>
            <div class="page-search">
                <v-toolbar outlined color="grey lighten-5" elevation="0">
            sdf
                </v-toolbar>
            </div>
        </div>
        <div class="content-wrapper">
            <v-navigation-drawer absolute v-model="drawer" color="grey lighten-5" >
            </v-navigation-drawer>
            <div class="content" :class="drawer ? '' : 'full'">
                <v-container>
                    {{ absolute }}
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Enim
                illo dolorem odio doloremque nulla vero blanditiis laborum sint
                nesciunt, iste ea unde corrupti illum deserunt dignissimos neque
                suscipit minima perspiciatis.
                </v-container>
               
            </div>
        </div>
    </div>
</template>
<script>
import Layout from "@/Layouts/AdminLayout";
export default {
    metaInfo: { title: "Usuarios" },
    layout: Layout,
    data: () => ({
        absolute: false,
        drawer: true,
        items: [
            { title: "Home", icon: "mdi-view-dashboard" },
            { title: "About", icon: "mdi-forum" },
        ],
    }),

    computed: {
        size_display: {
            get: function () {
                if (this.$vuetify.breakpoint.width > 960) {
                    this.absolute = false;
                    return true;
                }
                this.absolute = true;
                return false;
            },
            set: function (newValue) {},
        },
    },
    created() {
        this.drawer = this.$vuetify.breakpoint.width > 960 ? true : false;
        this.absolute = this.$vuetify.breakpoint.width > 960 ? false : true;
    },
};
</script>

<style>
.wrapper-page {
    width: 100%;
    height: 100%;
    background-color: #FAFAFA;
}

.page-heading {
    display: flex;
    justify-content: space-between;
}
.page-details {
    width: 256px;
    border-bottom: 1px solid rgba(0, 0, 0, .1);
    border-right: 1px solid rgba(0, 0, 0, .1);
}
.page-search {
    width: calc(100% - 256px);
    border-bottom: 1px solid rgba(0, 0, 0, .1);
}

.content-wrapper {
    position: relative;
    display: flex;
    width: 100%;
    height: 100%;
}

.content {
    width: 100%;
    margin-left: 256px;
    transition: all .3s ease;
}

.content.full {
    width: 100%;
    margin-left: 0;
}

@media (max-width: 960px) {
    .content {
        margin-left: 0;
    }

    .page-details {
        width: 200px;
    }
    .page-search {
        width: calc(100% - 200px);
    }
}
</style>
