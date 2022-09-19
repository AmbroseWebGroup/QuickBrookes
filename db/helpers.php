<?php

function formatInvoiceNumber($_num) {
  return "#".sprintf('%04d', $_num);
}

function formatDate($_date) {
  return substr($_date, 0, 10);
}

function formatCurrency($_curr) {
  return "£ ".number_format($_curr, 2);
}