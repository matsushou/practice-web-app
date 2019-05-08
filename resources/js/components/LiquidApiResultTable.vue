<template>
  <v-card>
    <v-card-title>
      API Result
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="api_results"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.currency_pair_code }}</td>
        <td class="text-xs-right">{{ props.item.id }}</td>
        <td class="text-xs-right">{{ props.item.code }}</td>
        <td class="text-xs-right">{{ props.item.market_ask }}</td>
        <td class="text-xs-right">{{ props.item.market_bid }}</td>
        <td class="text-xs-right">{{ props.item.volume_24h }}</td>
      </template>
      <template v-slot:no-results>
        <v-alert :value="true" color="error" icon="warning">
          Your search for "{{ search }}" found no results.
        </v-alert>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Currency Pair',
            align: 'left',
            sortable: false,
            value: ''
          },
          { text: 'ID', value: 'id' },
          { text: 'Code', value: 'code' },
          { text: 'Market Ask', value: 'market_ask' },
          { text: 'Market Bid', value: 'market_bid' },
          { text: 'Volume(24h)', value: 'volume_24h' }
        ],
      };
    },
    computed: {
        api_results: function () {
            console.log(this.results);
            if(this.results.length != 0){
                var obj= JSON.parse(this.results || "null");
            }
            return obj;
        }        
    },
    props: ['results']
  };
</script>