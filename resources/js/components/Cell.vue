<template>
  <div class="cell" @click="$emit('click')">
    <span v-if="valor">{{ valor }}</span>
  </div>
</template>

<script setup>
defineProps({
  fila: Number,
  columna: Number,
  valor: [String, Number, Object]
})
</script>

<style>
.cell {
  width: 80px;
  height: 80px;
  border: 1px solid #ccc;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
</style>