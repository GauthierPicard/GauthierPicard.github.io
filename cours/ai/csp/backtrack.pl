backtrack(Assignment) :-
    variables(Variables),                                            % get the predefined variables
    simplecheck(Variables,[],Assignment).                            % solve the problem and get an solution assignment

simplecheck([],_,[]).
simplecheck([X:DX|Variables],PartialAssignment,[(X,V)|Solution]) :-
    member(V,DX),                                                    % choose a value in the V's domain
    check((X,V),PartialAssignment),                                  % check the consistency of the chosen value
    simplecheck(Variables,[(X,V)|PartialAssignment],Solution).       % add the V's assignment to the partial one

check(_,[]).
check(Ai,[Aj|L]) :-
    consistent(Ai,Aj),
    check(Ai,L).
