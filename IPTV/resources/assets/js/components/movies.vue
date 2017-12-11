<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Title -->
                    <span>
                        Movies 
                    </span>
                    <!-- search input -->
                    <div class="form-group">
                        <input class="form-control" v-model="search.query" placeholder="Search"/>
                    </div>
                    <!-- Header action add new item -->
                    <a class="action-link" @click="showAddMovieForm">
                        Add New Movie
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="col-xs-1">number</th>
                                <th class="col-xs-2">name</th>
                                <th class="col-xs-2">stream</th>
                                <th class="col-xs-1">stream type</th>
                                <th class="col-xs-2">thumbnail</th>
                                <th class="col-xs-2">genre</th>
                                <th class="col-xs-1"></th>
                                <th class="col-xs-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="movie in movies" :key="movie.id">
                                <td class="col-xs-1">{{movie.number}}</td>
                                <td class="col-xs-2">{{movie.name}}</td>
                                <td class="col-xs-2">{{movie.stream.vid_stream}}</td>
                                <td class="col-xs-1">{{movie.stream.type.name}}</td>
                                <td class="col-xs-2">{{movie.thumbnail}}</td>
                                <td class="col-xs-2">
                                    <p v-for="genre in movie.genres" :key="genre.id">
                                        {{ genre.name }}
                                    </p>
                                </td>
                                <!-- Edit Button -->
                                <td  class="col-xs-1">
                                    <a class="action-link" @click="edit(movie)">
                                        Edit
                                    </a>
                                </td>

                                <!-- Delete Button -->
                                <td  class="col-xs-1">
                                    <a class="action-link text-danger" @click="destroy(movie)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <pagination :data="pagedata" v-on:pagination-change-page="getMovie"></pagination>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Movie Modal -->
        <div class="modal fade" id="modal-add-movie" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Add New Movie
                        </h4>
                    </div>

                    <div class="modal-body">
                        
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Movie Form -->
                        <div class="form-horizontal">
                            <!-- number -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="createForm.number">
                                </div>
                            </div>

                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="createForm.name">
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="createForm.stream">
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>

                            <!-- genre -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Genre</label>

                                <div class="col-md-7">
                                     <multiselect v-model="createForm.genres" :options="genres" :custom-label="nameWithLang" 
                                                placeholder="Select genres" label="name" track-by="name" 
                                                :multiple="true" :hide-selected="true" :close-on-select="false">
                                        <span class="custom__tag"><span>{{ genres.name }}</span><span class="custom__remove" >❌</span></span>
                                    </multiselect>
                                </div>
                            </div>
                            <!-- Stream Type -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream Type</label>

                                <div class="col-md-7">
                                    <select class="form-control" v-model="createForm.stream_type" single>
                                        <option v-for="stream_type in stream_types" :key="stream_type.id" v-bind:value="stream_type.id">{{stream_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Edit Movie Modal -->
        <div class="modal fade" id="modal-edit-movie" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Movie
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Movie Form -->
                        <div class="form-horizontal">
                            <!-- number -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="editForm.number">
                                </div>
                            </div>

                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="editForm.name">
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="text" class="form-control" v-model="editForm.stream">
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-movie-name" type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>

                            <!-- genre -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Genre</label>

                                <div class="col-md-7">
                                     <!-- <select class="form-control" v-model="editForm.genres" multiple>
                                        <option v-for="genre in genres" :key="genre.id" v-bind:value="genre.id">{{genre.name}}</option>
                                    </select> -->
                                    <multiselect v-model="editForm.genres" :options="genres" :custom-label="nameWithLang" 
                                                placeholder="Select genres" label="name" track-by="name" 
                                                :multiple="true" :hide-selected="true" :close-on-select="false">
                                        <span class="custom__tag"><span>{{ genres.name }}</span><span class="custom__remove" >❌</span></span>
                                    </multiselect>
                                </div>
                            </div>
                            <!-- Stream Type -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream Type</label>

                                <div class="col-md-7">
                                    <select class="form-control" v-model="editForm.stream_type" single>
                                        <option v-for="stream_type in stream_types" :key="stream_type.id" v-bind:value="stream_type.id">{{stream_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination';
    import multiselect from 'vue-multiselect';

    export default {
        components: {
            'pagination': pagination,
            'multiselect': multiselect
        },
        /*
         * The component's data.
         */
        data() {
            return {
                pagedata:{},

                movies: [],

                genres:[],

                stream_types:[],

                thumbnail:'',

                createForm: {
                    errors: [],
                    number: 0,
                    name: '',
                    stream: '',
                    stream_type: 0,
                    thumbnail: '',
                    genres : []
                },

                editForm: {
                    errors: [],
                    number: 0,
                    name: '',
                    stream: '',
                    stream_type: 0,
                    thumbnail: '',
                    genres : []
                },

                search: {
                    errors: [],
                    model: 'Movie',
                    query: ''
                }
            
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.getMovie();
        },

        /**
         * Watcher for search data 
         */
        watch: {
            'search.query': function(){
                if (this.search.query != '') {
                    axios.get('/search', {params : this.search})
                        .then(response => {
                            this.pagedata = response.data
                            this.movies = this.pagedata.data;
                        });
                } else {
                    this.getMovie();
                }
                
            }
        },

        methods: {
            nameWithLang ({ id, name }) {
                return `${name}`
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                vm.editForm.thumbnail = '';
                reader.onload = (e) => {
                    vm.createForm.thumbnail = e.target.result;
                    vm.editForm.thumbnail = e.target.result;
                     
                };
                reader.readAsDataURL(file);
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    console.log('wrg length');
                this.createImage(files[0]);
            },
            /**
             * Get all of the OAuth movies for the user.
             */
            getMovie(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/movie?page=' + page)
                    .then(response => {
                        this.pagedata = response.data.movies
                        this.movies = this.pagedata.data;
                        this.stream_types = response.data.stream_types;
                        this.genres = response.data.genres;
                    });
            },

            /**
             * Show the form for adding new movie.
             */
            showAddMovieForm() {
                this.createForm.number = this.movies[this.movies.length - 1].number + 1
                this.createForm.stream_type = 1;
                $('#modal-add-movie').modal('show');
            },

            /**
             * Create a new OAuth movie for the user.
             */
            store() {
                this.createForm.genres = _.map(this.createForm.genres, _.property('id'))
                this.persistMovie(
                    'post', '/movie',
                    this.createForm, '#modal-create-movie'
                );
            },

            /**
             * Edit the given movie.
             */
            edit(movie) {
                this.editForm.id = movie.id;
                this.editForm.name = movie.name;
                this.editForm.stream = movie.stream.vid_stream;
                this.editForm.thumbnail = movie.thumbnail;
                this.editForm.genres = movie.genres;
                this.editForm.number = movie.number;
                this.editForm.stream_type = movie.stream.type.id

                $('#modal-edit-movie').modal('show');
            },

            /**
             * Update the movie being edited.
             */
            update() {
                this.editForm.genres = _.map(this.editForm.genres, _.property('id'))
                this.persistMovie(
                    'put', '/movie/' + this.editForm.id,
                    this.editForm, '#modal-edit-movie'
                );
            },

             /**
             * Persist the movie to storage using the given form.
             */
            persistMovie(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getMovie();

                        form.errors = [];
                        form.name = '';
                        form.stream = '';
                        form.thumbnail = '';
                        form.genre = '';
                        form.number = '';

                        $(modal).modal('hide');
                        console.log(response);
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(movie) {
                axios.delete('/movie/' + movie.id)
                        .then(response => {
                            this.getMovie();
                        });
            },
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>