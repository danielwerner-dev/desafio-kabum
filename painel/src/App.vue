<template>
    <v-app>
        <v-content>
          <v-container fluid pa-0>
              <router-view>
              </router-view>
          </v-container>
        </v-content>
    </v-app>
</template>

<script>

export default {
  name: 'App',
  data () {
    return {}
  }
}
</script>
 
 <style>
 </style>