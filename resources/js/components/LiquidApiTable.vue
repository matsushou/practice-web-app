<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="liquid_apis"
      class="elevation-1"
    >
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.explanation }}</td>
        <td class="text-xs-right">
          <div v-if="props.item.need_auth">Authenticated</div>
          <div v-else>Public</div>
        </td>
        <td class="text-xs-right">{{ props.item.http_method }}</td>
        <td class="justify-center layout px-0">
          <v-btn color="primary" dark @click="execute(props.item)">Execute
            <v-icon dark right>check_circle</v-icon>
          </v-btn>
        </td>
      </template>
    </v-data-table>
    <liquid-api-result-table :results="results"/>
  </div>
</template>

<script>
  import result_table from "./LiquidApiResultTable.vue";
  import axios from 'axios';
  export default {
    data() {
      return {
        headers: [
          {
            text: 'Liquid APIs',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Explanation', value: 'explanation' },
          { text: 'Authenticated?', value: 'need_auth' },
          { text: 'HTTP Method', value: 'http_method' },
          { text: 'Execute', value: 'execute' }
        ],
        liquid_apis: [
          {
            name: 'Get Products',
            explanation: 'Get the list of all available products.',
            need_auth: false,
            http_method: 'GET',
            execute: 'execute button',
            path: '/api/liquid/get_products'
          },
          {
            name: 'Create an Order',
            explanation: 'Create a new order.',
            need_auth: true,
            http_method: 'POST',
            execute: 'execute button'
          },
          {
            name: 'Get an Order',
            explanation: 'Get an order info by order id.',
            need_auth: true,
            http_method: 'GET',
            execute: 'execute button'
          },
          {
            name: 'Get Orders',
            explanation: 'Get orders info (filter available).',
            need_auth: true,
            http_method: 'GET',
            execute: 'execute button'
          },        
          {
            name: 'Cancel an Order',
            explanation: 'Cancel an existing order by order id.',
            need_auth: true,
            http_method: 'PUT',
            execute: 'execute button'
          }, 
          {
            name: 'Get Fiat Accounts',
            explanation: 'Get fiat accounts info',
            need_auth: true,
            http_method: 'GET',
            execute: 'execute button'
          }, 
          {
            name: 'Create a Fiat Accounts',
            explanation: 'Create a new fiat account by currency',
            need_auth: true,
            http_method: 'POST',
            execute: 'execute button'
          }
        ],
        results: [],
        components: {
          result_table
        }
      };
    },
    
    methods: {
      execute (item) {
        switch(item.http_method){
          case 'GET':
            return axios.get(item.path)
             .then((res) => {
                 this.results = res.request.response;
              }
            );
        }
      },
    },
  };
</script>