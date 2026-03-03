# 📊 Mapa de Responsabilidades

---

## 🎯 Quem Faz O Quê?

| Feature | Laravel | .NET | Porque |
|---------|---------|------|--------|
| Renderizar HTML | ✅ | ❌ | Laravel renderiza. .NET retorna JSON |
| CRUD Banco Dados | ❌ | ✅ | .NET conecta ao banco |
| Autenticação | ❌ | ✅ | .NET gera JWT token |
| Validar Formulário | ✅ | ✅ | Ambos validam! Frontend (rápido) + Backend (seguro) |
| Videochamada | ❌ | ✅ | .NET gerencia WebSocket |
| Gerenciar Sessão | ✅ | ❌ | Laravel armazena em session |
| APIs REST | ❌ | ✅ | .NET cria endpoints |
| Exibir Dados | ✅ | ❌ | Laravel chama .NET e renderiza |
| Upload Arquivo | ✅* | ✅ | Laravel recebe, envia para .NET |

---

## 🔄 Fluxos Típicos

### 1. Listar Dados

```
Browser → Laravel → .NET → Banco → .NET → Laravel → HTML → Browser
```

### 2. Criar Dados

```
Browser (form) → Laravel (valida) → .NET (salva) → Banco
                                    ↓
                        Laravel renderiza sucesso
```

### 3. Autenticação

```
Browser → Laravel (form) → .NET (gera JWT) → Laravel (armazena) → Next requisições
```

---

## 💡 Resumo Uma Linha

**Laravel = Interface + Coordenação | .NET = Dados + Lógica**

---

**Data:** 11 de fevereiro de 2026
