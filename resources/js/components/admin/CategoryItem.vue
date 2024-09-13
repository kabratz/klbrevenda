<template>
  <div class="category-item">
    <div class="line" @click="toggleIsEditing">
      <!-- Verifica se a categoria está sendo editada -->
      <div class="column">
        <div v-if="isEditing">
          <input @click.stop v-model="editedName" />
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
    const isEditing = ref(false); // Estado de edição
    const editedName = ref(props.category.name); // Nome editável

    // Inicia o modo de edição
    const toggleIsEditing = () => {
      isEditing.value = !isEditing.value;
    };

    // Salva a edição e envia para o backend
    const saveEdit = async () => {
      try {
        // Faz a requisição para atualizar a categoria
        await axios.put(`/api/categories/${props.category.id}`, {
          name: editedName.value,
        });
        // Atualiza o nome localmente e sai do modo de edição
        props.category.name = editedName.value;
        isEditing.value = false;
      } catch (error) {
        console.error("Erro ao salvar a categoria:", error);
      }
    };

    const deleteCategory = async (categoryId) => {
      if (confirm("Você tem certeza que deseja remover esta categoria? Isto irá remover as subcategorias também!")) {
        try {
          await axios.delete(`/api/categories/${categoryId}`, {});
          window.location.reload();

        } catch (error) {
          console.error("Erro ao salvar a categoria:", error);
        }
      }
    };

    // Cancela a edição e restaura o nome original
    const cancelEdit = () => {
      editedName.value = props.category.name; // Restaura o valor original
      isEditing.value = false; // Sai do modo de edição
    };

    return {
      isEditing,
      editedName,
      toggleIsEditing,
      saveEdit,
      cancelEdit,
      deleteCategory
    };
  },
};
</script>

<style>
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
.child-category .line{
  background-color: #ddd;
}
.child-category .child-category .line{
  background-color: #eee;
}
</style>
