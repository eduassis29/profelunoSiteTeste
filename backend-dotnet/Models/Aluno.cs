using System;
using System.Collections.Generic;

namespace backend_dotnet.Models;

public partial class Aluno
{
    public long Id { get; set; }

    public long? UserId { get; set; }

    public string NomeAluno { get; set; } = null!;

    public DateTime? CreatedAt { get; set; }

    public DateTime? UpdatedAt { get; set; }

    public virtual ICollection<AlunoSala> AlunoSalas { get; set; } = new List<AlunoSala>();

    public virtual User? User { get; set; }
}
