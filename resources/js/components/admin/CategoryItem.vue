<template>
  <div class="category-item">
    <div class="line" @click="toggleIsEditing">
      <!-- Verifica se a categoria está sendo editada -->
      <div class="column">
        <div v-if="isEditing">
          <input @click.stop v-model="editedName" required />
        </div>
        <div v-else>
          {{ category.name }}
        </div>
      </div>
      <!-- Botões de ação (Editar, Salvar, Cancelar) -->
      <div class="actions">
        <button v-if="!isEditing" @click.stop="deleteCategory(category.id)">
          Excluir
        </button>
        <div v-if="isEditing">
          <button @click.stop="saveEdit">Salvar</button>
          <button @click.stop="cancelEdit">Cancelar</button>
        </div>
      </div>
    </div>

    <!-- Exibe as subcategorias, se houver -->
    <div v-if="category.children && category.children.length">
      <div v-for="child in category.children" :key="child.id" class="child-category">
        <CategoryItem :category="child" />
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";

export default {
  props: {
    category: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const isEditing = ref(false);
    const editedName = ref(props.category.name);

    const toggleIsEditing = () => {
      isEditing.value = !isEditing.value;
    };

    const saveEdit = async () => {
      if (!editedName.value) {
        alert("O nome da categoria não pode ser vazio!");
        return;
      }
      try {
        await axios.put(`/api/categories/${props.category.id}`, {
          name: editedName.value,
        });
        props.category.name = editedName.value;
        isEditing.value = false;
        alert("Categoria salva com sucesso!");
      } catch (error) {
        alert("Erro ao salvar categoria! Tente novamente mais tarde.");
        console.error("Erro ao salvar a categoria:", error);
      }
    };

    const deleteCategory = async (categoryId) => {
      if (
        confirm(
          "Você tem certeza que deseja remover esta categoria? Isto irá remover as subcategorias também!"
        )
      ) {
        try {
          await axios.delete(`/api/categories/${categoryId}`, {});
          alert("Categoria removida com sucesso!");
          window.location.reload();
        } catch (error) {
          alert("Erro ao remover categoria! Tente novamente mais tarde.");
          console.error("Erro ao salvar a categoria:", error);
        }
      }
    };

    const cancelEdit = () => {
      editedName.value = props.category.name;
      isEditing.value = false;
    };

    return {
      isEditing,
      editedName,
      toggleIsEditing,
      saveEdit,
      cancelEdit,
      deleteCategory,
    };
  },
};
</script>

<style scoped>
.child-category {
  padding-left: 30px;
}

.actions {
  margin-left: 10px;
}

.line {
  display: flex;
  padding: 4px;
  align-items: center;
  cursor: pointer;
  justify-content: space-between;
  border-bottom: solid 1px #bbb;
  background-color: #ccc;
}
.child-category .line {
  background-color: #ddd;
}
.child-category .child-category .line {
  background-color: #eee;
}
</style>
