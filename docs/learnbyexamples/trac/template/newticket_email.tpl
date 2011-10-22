<html>
{$ticket.url}

           Summary: {$ticket.summary}
           Product: {$ticket.product}
           Version: {$ticket.version}
            Status: {$ticket.status}
          Severity: {$ticket.severity}
          Priority: {$ticket.priority}
         Component: {$ticket.component}
        AssignedTo: {$ticket.owner}
        ReportedBy: {$ticket.reporter}
                CC: {$ticket.cc}

{$ticket.description}

------- You are receiving this mail because: ------- You are the {$trac_role} for the bug.
</html>