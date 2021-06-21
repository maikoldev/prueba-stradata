<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card mb-3">
          <div class="card-body">
            <form>
              <div class="form-row">
                <div class="col-7">
                  <div class="form-group">
                    <label for="name">Búsqueda por nombre</label>
                    <input id="name" type="text" class="form-control" v-model="form.name" />
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="percentage">Porcentaje de coincidencia</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                      </div>
                      <input id="percentage" type="number" class="form-control" v-model="form.percentage" />
                    </div>
                  </div>
                </div>
                <div class="col-2 d-flex align-items-end">
                  <button type="button" class="btn btn-primary mb-3" @click="search">Buscar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card" v-if="results || msg">
          <div class="card-body">
            <h3>Resultados:</h3>
            <template v-for="result in results">
              <div :key="result.id">{{ result.nombre }} - {{ result.percentage }}%</div>
            </template>
            <span v-if="msg">{{ msg }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        percentage: ''
      },
      results: null,
      msg: ''
    };
  },
  mounted() {},
  methods: {
    search() {
      const { name, percentage } = this.form;
      const apiUrl = `${process.env.MIX_APP_URL}/api/accuracy-percentage`;
      const urlParams = `?name=${name}&percentage=${percentage}`;

      this.results = null;
      this.msg = null;

      fetch(`${apiUrl}${urlParams}`)
        .then(res => res.json())
        .then(data => {
          if (data.message) {
            this.msg = data.message;
          } else {
            this.results = data.names_found;
          }
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
