<template>
    <div>
        <datatable
                :headers="headers"
                :transport="transport"
        >
            <template slot="columns" slot-scope="props">
                <td class="text-xs-center">{{ props.item.id }}</td>
                <td class="text-xs-center">
                    <v-edit-dialog
                            @open="props.item._name = props.item.name"
                            @cancel="props.item.name = props.item._name || props.item.name"
                            lazy
                    > {{ props.item.name }}
                        <v-text-field
                                slot="input"
                                label="Name"
                                single-line
                                :value="props.item.name"
                                :disabled="true"
                                @change="props.edit(props.item,'name', $event)"
                        ></v-text-field>
                    </v-edit-dialog>
                </td>
                <td class="">
                    <v-btn @click="join(props.item)" icon color="primary" dark>
                        <v-icon dark>delete</v-icon>
                    </v-btn>
                </td>
                <td class="">
                    <v-btn @click="props.delete(props.item, $event)" icon color="error" dark>
                        <v-icon dark>delete</v-icon>
                    </v-btn>
                </td>
            </template>
            <div slot="create_title">New Room</div>
            <template slot="create_content" slot-scope="props">
                <v-text-field label="Name" name="name" v-model="transport.create.data.models.name"></v-text-field>
            </template>
        </datatable>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                transport: {
                    read: {
                        url: '/rooms/data',
                    },
                    update: {
                        url: (item) => {
                            return '/rooms/' + item.id
                        }
                    },
                    delete: {
                        url: (item) => {
                            return '/rooms/' + item.id
                        }
                    },
                    multi_delete: {
                        url: '/rooms/multi_delete'
                    },
                    create: {
                        url: '/rooms',
                        data: {
                            models: {
                                name: null
                            },
                            defaults: {
                                name: null
                            }
                        },
                    }
                },
                headers: [
                    {
                        text: 'ID',
                        value: 'id',
                        width: '80px',
                        class: 'text-xs-center'
                    },
                    {
                        text: 'Name',
                        value: 'name',
                    },
                    {
                        text: 'Join',
                        value: 'join',
                        sortable: false,
                        width: '50px',
                        searchable: false,
                    },
                    {
                        text: 'Delete',
                        value: 'delete',
                        sortable: false,
                        width: '50px',
                        searchable: false,
                    },
                ]
            }
        },
        methods: {
            join(item){
                this.$router.push({name: 'room-selected', params: {id: item.id}});
            }
        }
    }
</script>
