<script setup>
const props = defineProps({
  amount: {
    type: Number,
    required: true
  }
});

const formatAmount = (amount) => {
  return Number(Number(amount).toFixed(2)).toLocaleString();
}
</script>

<template>
  <span>{{ formatAmount(props.amount) }}</span>
</template>
