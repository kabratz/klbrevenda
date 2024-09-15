<style scoped>
.container {
  margin-top: 130px;
  justify-content: center;
}

.card-body,
.card-body form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.card {
  width: 800px;
  margin-top: 50px;
  align-self: center;
  text-align: center;
  justify-content: center;
}
input[type="file"] {
  text-align-last: center;
}
</style>

<template>
  <header-admin> </header-admin>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">
          <h1>Importar Produtos</h1>
        </div>

        <div class="card-body">
          <p>
            <a
              href="https://docs.google.com/spreadsheets/d/1ngcOoNZF8ClaedTW3k3pEq2BFZ1eiQKwCEf_f2zqjqw/edit?usp=sharing"
              target="_blank"
            >
              Aqui você pode encontrar um exemplo de arquivo CSV para importar produtos.
            </a>
          </p>

          <p>
            Para fazer o seu arquivo, basta entrar no link acima, fazer uma cópia do
            arquivo para seu drive (se preferir, pode fazer download para seu computador),
            preencher os campos de acordo com a descrição e salvar o arquivo no formato
            CSV.
            <br />
            <br />
            Após isso, basta selecionar o arquivo e clicar em "Fazer upload e importar".
          </p>
          <form @submit.prevent="uploadFile">
            <label for="csvFile">Selecione um arquivo CSV:</label>
            <input type="file" id="csvFile" @change="handleFileUpload" accept=".csv" required/>
            <button type="submit" class="button-primary">Fazer upload e importar</button>
          </form>

          <div v-if="importStatus" class="mt-3">
            <p>{{ importStatus }}</p>
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
      file: null,
      importStatus: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.file = event.target.files[0];
    },
    uploadFile() {
      if (!this.file) {
        this.importStatus = "Por favor, selecione um arquivo.";
        return;
      }

      if (this.file.type !== "text/csv") {
        this.importStatus = "Por favor, selecione um arquivo CSV.";
        return;
      }

      const formData = new FormData();
      formData.append("file", this.file);

      fetch("/api/import-csv", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          this.importStatus = data.message;
        })
        .catch((error) => {
          console.error("Error:", error);
          this.importStatus = "Erro ao baixar arquivo.";
        });
    },
  },
};
</script>
